<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TestPackage;
use App\Models\TestAttempt;
use App\Models\TestRequest;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Total Students
        $totalStudents = User::where('role', 'student')->count();

        // Total Questions in Bank
        $totalQuestions = \App\Models\Question::count();

        // Active Attempts (not yet submitted, totalScore is null)
        $totalActiveAttempts = TestAttempt::whereNull('totalScore')->count();

        // Pending Requests
        $totalPendingRequests = TestRequest::where('status', 'PENDING')->count();

        return view('admin.dashboard', compact(
            'totalStudents', 
            'totalQuestions', 
            'totalActiveAttempts', 
            'totalPendingRequests'
        ));
    }

    public function bankSoal()
    {
        $packages = TestPackage::orderBy('name')->get();
        $questions = \App\Models\Question::with(['audio', 'passage', 'package'])->orderBy('section')->get();
        $passages = \App\Models\Passage::orderBy('createdAt', 'desc')->get();
        return view('admin.bank-soal', compact('questions', 'packages', 'passages'));
    }

    public function storeQuestion(Request $request)
    {
        $request->validate([
            'section' => 'required|string',
            'content' => 'required|array',
            'content.*' => 'required|string',
            'answerKey' => 'required|array',
            'answerKey.*' => 'required|string',
            'choice_a' => 'required|array',
            'choice_a.*' => 'required|string',
            'choice_b' => 'required|array',
            'choice_b.*' => 'required|string',
            'choice_c' => 'required|array',
            'choice_c.*' => 'required|string',
            'choice_d' => 'required|array',
            'choice_d.*' => 'required|string',
            'packageId' => 'nullable|string',
        ]);

        $audioId = null;
        if ($request->hasFile('audioFile')) {
            $path = $request->file('audioFile')->store('audios', 'public');
            $audio = \App\Models\Audio::create([
                'id' => \Illuminate\Support\Str::uuid()->toString(),
                'fileUrl' => '/storage/' . $path,
            ]);
            $audioId = $audio->id;
        }

        $passageId = null;
        if ($request->input('section') === 'Reading') {
            if ($request->input('passage_id') && $request->input('passage_id') !== 'new') {
                $passageId = $request->input('passage_id');
            } else if ($request->filled('passageTitle') && $request->filled('passageContent')) {
                $passage = \App\Models\Passage::create([
                    'id' => \Illuminate\Support\Str::uuid()->toString(),
                    'title' => $request->input('passageTitle'),
                    'content' => $request->input('passageContent'),
                ]);
                $passageId = $passage->id;
            }
        }

        $contents = $request->input('content');
        $choiceAs = $request->input('choice_a');
        $choiceBs = $request->input('choice_b');
        $choiceCs = $request->input('choice_c');
        $choiceDs = $request->input('choice_d');
        $answerKeys = $request->input('answerKey');

        foreach ($contents as $index => $content) {
            $q = \App\Models\Question::create([
                'id' => \Illuminate\Support\Str::uuid()->toString(),
                'section' => $request->input('section'),
                'content' => $content,
                'choices' => json_encode([
                    'a' => $choiceAs[$index] ?? '',
                    'b' => $choiceBs[$index] ?? '',
                    'c' => $choiceCs[$index] ?? '',
                    'd' => $choiceDs[$index] ?? '',
                ]),
                'answerKey' => $answerKeys[$index] ?? 'a',
                'audioId' => $audioId,
                'passageId' => $passageId,
                'packageId' => $request->input('packageId'),
            ]);

            $this->syncQuestionToAllPackages($q->id);
        }

        return redirect()->back()->with('success', 'Soal berhasil ditambahkan!');
    }

    public function updateQuestion(Request $request, $id)
    {
        $request->validate([
            'section' => 'required|string',
            'content' => 'required|string',
            'answerKey' => 'required|string',
            'choice_a' => 'required|string',
            'choice_b' => 'required|string',
            'choice_c' => 'required|string',
            'choice_d' => 'required|string',
            'packageId' => 'nullable|string',
        ]);

        $question = \App\Models\Question::findOrFail($id);
        
        $audioId = $question->audioId;
        if ($request->hasFile('audioFile')) {
            $path = $request->file('audioFile')->store('audios', 'public');
            $audio = \App\Models\Audio::create([
                'id' => \Illuminate\Support\Str::uuid()->toString(),
                'fileUrl' => '/storage/' . $path,
            ]);
            $audioId = $audio->id;
        }

        $passageId = $question->passageId;
        $passageId = $question->passageId;
        if ($request->input('section') === 'Reading') {
            if ($request->input('passage_id') && $request->input('passage_id') !== 'new') {
                $passageId = $request->input('passage_id');
            } else if ($request->filled('passageTitle') && $request->filled('passageContent')) {
                $passage = \App\Models\Passage::create([
                    'id' => \Illuminate\Support\Str::uuid()->toString(),
                    'title' => $request->input('passageTitle'),
                    'content' => $request->input('passageContent'),
                ]);
                $passageId = $passage->id;
            }
        }

        $oldPackageId = $question->packageId;

        $question->update([
            'section' => $request->input('section'),
            'content' => $request->input('content'),
            'choices' => json_encode([
                'a' => $request->input('choice_a'),
                'b' => $request->input('choice_b'),
                'c' => $request->input('choice_c'),
                'd' => $request->input('choice_d'),
            ]),
            'answerKey' => $request->input('answerKey'),
            'audioId' => $audioId,
            'passageId' => $passageId,
            'packageId' => $request->input('packageId'),
        ]);

        if ($oldPackageId && $oldPackageId !== $request->input('packageId')) {
            $this->removeQuestionFromPackage($question->id, $oldPackageId);
        }

        $this->syncQuestionToAllPackages($question->id);

        return redirect()->back()->with('success', 'Soal berhasil diperbarui!');
    }

    public function destroyQuestion($id)
    {
        $question = \App\Models\Question::findOrFail($id);
        $questionId = $question->id;
        $question->delete();

        $this->removeQuestionFromAllPackages($questionId);

        return redirect()->back()->with('success', 'Soal berhasil dihapus!');
    }

    public function paketTes()
    {
        $packages = TestPackage::orderBy('name')->get();
        $questions = \App\Models\Question::with(['audio', 'passage'])->get(); // for the builder
        return view('admin.paket-tes', compact('packages', 'questions'));
    }

    public function storePackage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:Full Test,Mini Test',
            'question_ids' => 'required|array|min:1',
            'question_ids.*' => 'exists:questions,id',
            'duration_listening' => 'required|numeric|min:0',
            'duration_structure' => 'required|numeric|min:0',
            'duration_reading' => 'required|numeric|min:0',
            'instruction_listening' => 'nullable|string',
            'instruction_structure' => 'nullable|string',
            'instruction_reading' => 'nullable|string',
        ]);

        $selectedQuestions = \App\Models\Question::with(['audio', 'passage'])->whereIn('id', $request->input('question_ids'))->get();
        $questionsJson = [];

        foreach ($selectedQuestions as $q) {
            $choices = json_decode($q->choices, true);
            $shuffledEntries = [];
            if ($choices) {
                foreach ($choices as $k => $v) {
                    $shuffledEntries[] = [$k, $v]; // Simplified shuffling logic for snapshot
                }
            }

            $questionData = [
                'id' => $q->id,
                'section' => $q->section,
                'content' => $q->content,
                'choices' => $choices,
                'answerKey' => $q->answerKey,
                'shuffledEntries' => $shuffledEntries,
            ];

            if ($q->audio) {
                $questionData['audio'] = ['fileUrl' => $q->audio->fileUrl];
            }
            if ($q->passage) {
                $questionData['passage'] = [
                    'title' => $q->passage->title,
                    'content' => $q->passage->content,
                ];
            }

            $questionsJson[] = $questionData;
        }

        $durations = [
            'Listening' => $request->input('duration_listening') * 60,
            'Structure' => $request->input('duration_structure') * 60,
            'Reading' => $request->input('duration_reading') * 60,
        ];

        \App\Models\TestPackage::create([
            'id' => \Illuminate\Support\Str::uuid()->toString(),
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'status' => 'published',
            'questions' => $questionsJson,
            'durations' => $durations,
            'instruction_listening' => $request->input('instruction_listening'),
            'instruction_structure' => $request->input('instruction_structure'),
            'instruction_reading' => $request->input('instruction_reading'),
        ]);

        return redirect()->back()->with('success', 'Paket Tes berhasil dibuat!');
    }

    public function updatePackage(Request $request, $id)
    {
        $package = TestPackage::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:Full Test,Mini Test',
            'question_ids' => 'required|array|min:1',
            'question_ids.*' => 'exists:questions,id',
            'duration_listening' => 'nullable|numeric|min:0',
            'duration_structure' => 'nullable|numeric|min:0',
            'duration_reading' => 'nullable|numeric|min:0',
            'instruction_listening' => 'nullable|string',
            'instruction_structure' => 'nullable|string',
            'instruction_reading' => 'nullable|string',
        ]);

        $selectedQuestions = \App\Models\Question::with(['audio', 'passage'])->whereIn('id', $request->input('question_ids'))->get();
        $questionsJson = [];

        foreach ($selectedQuestions as $q) {
            $choices = is_string($q->choices) ? json_decode($q->choices, true) : $q->choices;
            $shuffledEntries = [];
            if ($choices) {
                foreach ($choices as $k => $v) {
                    $shuffledEntries[] = [$k, $v];
                }
            }

            $questionData = [
                'id' => $q->id,
                'section' => $q->section,
                'content' => $q->content,
                'choices' => $choices,
                'answerKey' => $q->answerKey,
                'shuffledEntries' => $shuffledEntries,
            ];

            if ($q->audio) {
                $questionData['audio'] = ['fileUrl' => $q->audio->fileUrl];
            }
            if ($q->passage) {
                $questionData['passage'] = [
                    'title' => $q->passage->title,
                    'content' => $q->passage->content,
                ];
            }

            $questionsJson[] = $questionData;
        }

        $durations = [
            'Listening' => (float)$request->input('duration_listening') * 60,
            'Structure' => (float)$request->input('duration_structure') * 60,
            'Reading' => (float)$request->input('duration_reading') * 60,
        ];

        $package->update([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'questions' => $questionsJson,
            'durations' => $durations,
            'instruction_listening' => $request->input('instruction_listening'),
            'instruction_structure' => $request->input('instruction_structure'),
            'instruction_reading' => $request->input('instruction_reading'),
        ]);

        return redirect()->back()->with('success', 'Paket Tes berhasil diperbarui!');
    }

    public function destroyPackage($id)
    {
        $package = TestPackage::findOrFail($id);
        $package->delete();
        return redirect()->back()->with('success', 'Paket Tes berhasil dihapus!');
    }

    public function mahasiswa()
    {
        $students = \App\Models\User::with(['attempts.package'])->where('role', 'student')->orderBy('createdAt', 'desc')->get();
        return view('admin.mahasiswa', compact('students'));
    }

    public function requests()
    {
        $testRequests = TestRequest::with(['user', 'package'])->orderBy('createdAt', 'desc')->get();
        return view('admin.requests', compact('testRequests'));
    }
    
    public function updateRequest(Request $request, $id)
    {
        $testRequest = TestRequest::findOrFail($id);
        $testRequest->status = strtolower($request->input('status')); // pending, approved, rejected
        $testRequest->save();
        
        return redirect()->back()->with('success', 'Status permohonan ujian berhasil diperbarui.');
    }
    
    public function pengaturan()
    {
        $admins = User::whereIn('role', ['admin', 'superadmin'])->orderBy('createdAt', 'desc')->get();
        return view('admin.pengaturan', compact('admins'));
    }
    
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,superadmin'
        ]);
        
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->passwordHash = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->role = $request->role;
        // set default values for non-nullable fields if any
        $user->nim = '-';
        $user->fakultas = '-';
        $user->prodi = '-';
        $user->save();
        
        return redirect()->back()->with('success', 'Akun ' . strtoupper($request->role) . ' berhasil ditambahkan.');
    }
}
