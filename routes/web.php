<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;

// ─── ROOT ────────────────────────────────────────────────────────────────────
Route::get('/', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;
        return redirect(in_array($role, ['admin', 'superadmin'])
            ? route('admin.dashboard')
            : route('student.dashboard'));
    }
    return redirect()->route('student.login');
});

// ─── STUDENT AUTH ─────────────────────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showStudentLogin'])->name('student.login');
Route::post('/login', [AuthController::class, 'studentLogin'])->name('student.login.post');
Route::get('/daftar', [AuthController::class, 'showStudentRegister'])->name('student.register');
Route::post('/daftar', [AuthController::class, 'studentRegister'])->name('student.register.post');

// ─── ADMIN AUTH ───────────────────────────────────────────────────────────────
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');

// ─── LOGOUT ───────────────────────────────────────────────────────────────────
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── STUDENT ROUTES ───────────────────────────────────────────────────────────
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

// ─── ADMIN ROUTES ─────────────────────────────────────────────────────────────
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

// ─── SUPERADMIN ROUTES ────────────────────────────────────────────────────────
Route::prefix('admin')->middleware([\App\Http\Middleware\CheckRole::class.':superadmin'])->group(function () {
    Route::get('/dashboard/pengaturan', [AdminController::class, 'pengaturan'])->name('admin.pengaturan');
    Route::post('/dashboard/pengaturan/store', [AdminController::class, 'storeAdmin'])->name('admin.pengaturan.store');
});

// ─── STREAM AUDIO ─────────────────────────────────────────────────────────────
Route::get('/stream-audio/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) abort(404);
    return response()->file($filePath);
})->where('path', '.*');

// ─── EMERGENCY ADMIN BYPASS ───────────────────────────────────────────────────
Route::get('/admin-masuk', function () {
    $admin = \App\Models\User::whereIn('role', ['superadmin', 'admin'])->first();
    if (!$admin) abort(404, 'Tidak ada akun admin.');
    \Illuminate\Support\Facades\Auth::login($admin, true);
    return redirect()->route('admin.dashboard');
});

// ─── TEMPORARY SCHEMA FIX ────────────────────────────────────────────────────
Route::get('/migrate-fix', function () {
    try {
        if (!Schema::hasColumn('users', 'id')) {
            Schema::table('users', function($table) {
                $table->uuid('id')->nullable()->first();
            });
        }

        foreach (DB::table('users')->get() as $row) {
            if (empty($row->id)) {
                DB::table('users')->where('email', $row->email)->update([
                    'id' => (string) Illuminate\Support\Str::uuid()
                ]);
            }
        }

        Schema::table('users', function($table) {
            $table->uuid('id')->nullable(false)->change();
        });

        try {
            Schema::table('users', function($table) {
                $table->primary('id');
            });
        } catch (\Exception $e) {
            // Already primary key
        }

        Schema::table('users', function($table) {
            if (!Schema::hasColumn('users', 'nim')) {
                $table->string('nim', 50)->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'fakultas')) {
                $table->string('fakultas', 100)->nullable()->after('nim');
            }
            if (!Schema::hasColumn('users', 'prodi')) {
                $table->string('prodi', 100)->nullable()->after('fakultas');
            }
        });

        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'AdminSeeder']);
        $output = \Illuminate\Support\Facades\Artisan::output();

        return "✅ Sinkronisasi skema tabel users dan Seeder Admin berhasil!<br><pre>" . $output . "</pre>";
    } catch (\Exception $e) {
        return "❌ Error: " . $e->getMessage();
    }
});
