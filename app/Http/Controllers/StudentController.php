<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TestPackage;
use App\Models\TestAttempt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $attempts = TestAttempt::where('userId', $user->id)->orderBy('date', 'desc')->get();

        return view('student.dashboard', compact('attempts'));
    }

    public function packages()
    {
        $packages = TestPackage::where('status', 'published')->get();
        return view('student.packages', compact('packages'));
    }

    public function history()
    {
        $user = Auth::user();
        $attempts = TestAttempt::with('package')->where('userId', $user->id)->orderBy('date', 'desc')->get();
        return view('student.history', compact('attempts'));
    }

    public function showExam($id)
    {
        $package = TestPackage::findOrFail($id);
        $user = Auth::user();
        
        // Cek percobaan ujian dalam 7 hari terakhir
        $recentAttemptsCount = TestAttempt::where('userId', $user->id)
                                ->where('createdAt', '>=', now()->subDays(7))
                                ->count();
        
        $hasQuota = ($recentAttemptsCount === 0);
        
        $pendingRequest = \App\Models\TestRequest::where('userId', $user->id)
                            ->where('packageId', $id)
                            ->where('status', 'pending')
                            ->first();
                            
        $approvedRequest = \App\Models\TestRequest::where('userId', $user->id)
                            ->where('packageId', $id)
                            ->where('status', 'approved')
                            ->first();

        // Tampilkan halaman prep-test
        return view('student.exam-prep', compact('package', 'hasQuota', 'pendingRequest', 'approvedRequest'));
    }

    public function startExam(Request $request, $id)
    {
        $package = TestPackage::findOrFail($id);
        $user = Auth::user();

        // Cek weekly limit
        $recentAttemptsCount = TestAttempt::where('userId', $user->id)
                                ->where('createdAt', '>=', now()->subDays(7))
                                ->count();
        
        if ($recentAttemptsCount > 0) {
            $approvedRequest = \App\Models\TestRequest::where('userId', $user->id)
                            ->where('packageId', $id)
                            ->where('status', 'approved')
                            ->first();
                            
            if (!$approvedRequest) {
                return redirect()->back()->with('error', 'Anda telah mencapai batas maksimal pengerjaan ujian minggu ini. Silakan ajukan permohonan kuota.');
            } else {
                // Tandai sudah dipakai
                $approvedRequest->status = 'used';
                $approvedRequest->save();
            }
        }

        // Buat TestAttempt baru
        $attempt = new TestAttempt();
        $attempt->id = Str::uuid()->toString();
        $attempt->userId = $user->id;
        $attempt->packageId = $package->id;
        $attempt->durationSeconds = 0; // Mulai dari 0
        $attempt->answers = [];
        $attempt->save();

        return redirect()->route('student.exam.run', $attempt->id);
    }
    
    public function requestQuota(Request $request, $id)
    {
        $package = TestPackage::findOrFail($id);
        $user = Auth::user();
        
        $existing = \App\Models\TestRequest::where('userId', $user->id)
                        ->where('packageId', $id)
                        ->whereIn('status', ['pending', 'approved'])
                        ->first();
                        
        if ($existing) {
            return redirect()->back()->with('error', 'Anda sudah memiliki permohonan yang sedang diproses atau disetujui.');
        }
        
        \App\Models\TestRequest::create([
            'id' => Str::uuid()->toString(),
            'userId' => $user->id,
            'packageId' => $id,
            'status' => 'pending'
        ]);
        
        return redirect()->back()->with('success', 'Permohonan kuota ujian berhasil diajukan. Silakan tunggu persetujuan Admin.');
    }

    public function runExam($id)
    {
        $attempt = TestAttempt::with('package')->findOrFail($id);
        $user = Auth::user();

        if ($attempt->userId !== $user->id) {
            abort(403);
        }

        if ($attempt->totalScore !== null) {
            // Sudah disubmit
            return redirect()->route('student.result', $attempt->id);
        }

        // Return halaman CBT Engine
        return view('student.exam-run', compact('attempt'));
    }

    public function saveExam(Request $request, $id)
    {
        $attempt = TestAttempt::findOrFail($id);
        
        if ($attempt->userId !== Auth::id() || $attempt->totalScore !== null) {
            return response()->json(['success' => false], 403);
        }

        $attempt->answers = $request->input('answers', []);
        $attempt->durationSeconds = $request->input('durationSeconds', 0);
        $attempt->save();

        return response()->json(['success' => true]);
    }

    public function submitExam(Request $request, $id)
    {
        $attempt = TestAttempt::findOrFail($id);
        
        if ($attempt->userId !== Auth::id()) {
            return response()->json(['success' => false], 403);
        }

        // Simpan sisa data
        $attempt->answers = $request->input('answers', []);
        $attempt->durationSeconds = $request->input('durationSeconds', 0);

        // Kalkulasi Skor
        $package = $attempt->package;
        $questions = is_array($package->questions) ? $package->questions : json_decode($package->questions, true) ?? [];
        
        $rawScores = ['Listening' => 0, 'Structure' => 0, 'Reading' => 0];
        $totalQuestions = ['Listening' => 0, 'Structure' => 0, 'Reading' => 0];

        // Hitung jawaban benar
        $answers = $attempt->answers ?? [];
        foreach ($questions as $q) {
            $sec = $q['section'];
            if (isset($totalQuestions[$sec])) {
                $totalQuestions[$sec]++;
            }
            
            $qId = $q['id'];
            $correctAnswer = $q['answerKey'] ?? null;
            $userAnswer = $answers[$qId] ?? null;

            if ($correctAnswer && $userAnswer === $correctAnswer) {
                if (isset($rawScores[$sec])) {
                    $rawScores[$sec]++;
                }
            }
        }

        // Kalkulasi Scaled Scores
        $scaledScores = ['Listening' => 31, 'Structure' => 31, 'Reading' => 31];
        $minMax = [
            'Listening' => ['min' => 31, 'max' => 68],
            'Structure' => ['min' => 31, 'max' => 68],
            'Reading'   => ['min' => 31, 'max' => 67],
        ];

        foreach (['Listening', 'Structure', 'Reading'] as $sec) {
            $raw = $rawScores[$sec];
            $total = $totalQuestions[$sec];
            
            if ($total == 0) {
                $scaledScores[$sec] = $minMax[$sec]['min'];
                continue;
            }

            // Coba ambil dari database konversi jika ada
            $conversion = \App\Models\ScoreConversion::where('section', $sec)->where('rawScore', $raw)->first();
            if ($conversion && $total == 140) { 
                // Opsional: Tabel DB biasanya spesifik untuk 140 total soal (L:50, S:40, R:50)
                // Jika soal tidak standar, lebih akurat pakai rumus interpolasi.
                $scaledScores[$sec] = $conversion->scaledScore;
            } else {
                // Formula Interpolasi Linier (Fallback jika data tidak ada atau jumlah soal dinamis)
                $min = $minMax[$sec]['min'];
                $max = $minMax[$sec]['max'];
                $scaled = $min + (($raw / $total) * ($max - $min));
                $scaledScores[$sec] = round($scaled);
            }
        }

        // Skor Total (Rata-rata * 10)
        $totalScore = (int) round((($scaledScores['Listening'] + $scaledScores['Structure'] + $scaledScores['Reading']) / 3) * 10);

        // Simpan ke DB
        $attempt->rawScores = [
            'listening' => $rawScores['Listening'], 
            'structure' => $rawScores['Structure'], 
            'reading' => $rawScores['Reading']
        ];
        $attempt->scaledScores = [
            'listening' => $scaledScores['Listening'], 
            'structure' => $scaledScores['Structure'], 
            'reading' => $scaledScores['Reading']
        ];
        $attempt->totalScore = $totalScore;

        $attempt->save();

        return response()->json(['success' => true, 'redirect' => route('student.result', ['id' => $attempt->id])]);
    }

    public function showResult($id)
    {
        $attempt = TestAttempt::with('package')->findOrFail($id);
        
        if ($attempt->userId !== Auth::id()) {
            abort(403);
        }

        return view('student.result', compact('attempt'));
    }
}
