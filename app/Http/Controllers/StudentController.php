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

        // TODO: Kalkulasi Skor (sementara pakai dummy atau hitung sederhana)
        // Di sistem asli, ini akan mencocokkan jawaban dengan $package->questions dan $score_conversions
        $answers = $attempt->answers ?? [];
        $correctCount = count($answers); // dummy
        
        $attempt->rawScores = ['listening' => $correctCount, 'structure' => $correctCount, 'reading' => $correctCount];
        $attempt->scaledScores = ['listening' => 50, 'structure' => 50, 'reading' => 50]; // dummy
        $attempt->totalScore = 500; // dummy

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
