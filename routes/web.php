<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Student Routes
    Route::middleware([\App\Http\Middleware\CheckRole::class.':student'])->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
        Route::get('/dashboard/packages', [StudentController::class, 'packages'])->name('student.packages');
        Route::get('/dashboard/history', [StudentController::class, 'history'])->name('student.history');
        Route::get('/exam/package/{id}', [StudentController::class, 'showExam'])->name('student.exam');
        Route::post('/exam/package/{id}/start', [StudentController::class, 'startExam'])->name('student.exam.start');
        Route::post('/exam/package/{id}/request', [StudentController::class, 'requestQuota'])->name('student.exam.request');
        Route::get('/exam/attempt/{id}', [StudentController::class, 'runExam'])->name('student.exam.run');
        Route::post('/exam/attempt/{id}/save', [StudentController::class, 'saveExam'])->name('student.exam.save');
        Route::post('/exam/attempt/{id}/submit', [StudentController::class, 'submitExam'])->name('student.exam.submit');
        Route::get('/exam/result/{id}', [StudentController::class, 'showResult'])->name('student.result');
    });

    // Admin Routes
    Route::prefix('admin')->middleware([\App\Http\Middleware\CheckRole::class.':admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/dashboard/bank-soal', [AdminController::class, 'bankSoal'])->name('admin.bank-soal');
        Route::post('/dashboard/bank-soal', [AdminController::class, 'storeQuestion'])->name('admin.bank-soal.store');
        Route::put('/dashboard/bank-soal/{id}', [AdminController::class, 'updateQuestion'])->name('admin.bank-soal.update');
        Route::delete('/dashboard/bank-soal/{id}', [AdminController::class, 'destroyQuestion'])->name('admin.bank-soal.destroy');
        Route::get('/dashboard/paket-tes', [AdminController::class, 'paketTes'])->name('admin.paket-tes');
        Route::post('/dashboard/paket-tes', [AdminController::class, 'storePackage'])->name('admin.paket-tes.store');
        Route::put('/dashboard/paket-tes/{id}', [AdminController::class, 'updatePackage'])->name('admin.paket-tes.update');
        Route::delete('/dashboard/paket-tes/{id}', [AdminController::class, 'destroyPackage'])->name('admin.paket-tes.destroy');
        Route::get('/dashboard/requests', [AdminController::class, 'requests'])->name('admin.requests');
        Route::put('/dashboard/requests/{id}', [AdminController::class, 'updateRequest'])->name('admin.requests.update');
        Route::get('/dashboard/mahasiswa', [AdminController::class, 'mahasiswa'])->name('admin.mahasiswa');
    });

    // Super Admin Routes
    Route::prefix('admin')->middleware([\App\Http\Middleware\CheckRole::class.':superadmin'])->group(function () {
        Route::get('/dashboard/pengaturan', [AdminController::class, 'pengaturan'])->name('admin.pengaturan');
        Route::post('/dashboard/pengaturan/store', [AdminController::class, 'storeAdmin'])->name('admin.pengaturan.store');
    });

    // Fallback route for storage files (useful for Windows with php artisan serve)
    Route::get('/stream-audio/{path}', function ($path) {
        $filePath = storage_path('app/public/' . $path);
        if (!file_exists($filePath)) {
            abort(404);
        }
        return response()->file($filePath);
    })->where('path', '.*');

    // Debug Routes
    Route::get('/debug-session-set', function () {
        session(['test_session' => 'IT WORKS!']);
        return redirect('/debug-session-get');
    });
    
    Route::get('/debug-session-get', function () {
        return session()->all();
    });
