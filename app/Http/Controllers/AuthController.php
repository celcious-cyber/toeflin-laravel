<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // ─── STUDENT ──────────────────────────────────────────────────────────────

    public function showStudentLogin()
    {
        if (Auth::check() && Auth::user()->role === 'student') {
            return redirect()->route('student.dashboard');
        }
        return view('auth.student-login');
    }

    public function studentLogin(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim'  => ['required', 'string', 'max:50'],
        ]);

        $dummyEmail = Str::slug($validated['name'] . ' ' . $validated['nim']) . '@student.toeflin.com';
        $user = User::where('email', $dummyEmail)->first();

        if (!$user) {
            return back()
                ->withInput()
                ->withErrors(['nim' => 'Akun tidak ditemukan. Pastikan Nama dan NIM sudah benar, atau daftar terlebih dahulu.']);
        }

        Auth::login($user, true);
        return redirect()->route('student.dashboard');
    }

    public function showStudentRegister()
    {
        if (Auth::check() && Auth::user()->role === 'student') {
            return redirect()->route('student.dashboard');
        }
        return view('auth.student-register');
    }

    public function studentRegister(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'nim'      => ['required', 'string', 'max:50'],
            'fakultas' => ['nullable', 'string', 'max:100'],
            'prodi'    => ['nullable', 'string', 'max:100'],
        ]);

        $dummyEmail = Str::slug($validated['name'] . ' ' . $validated['nim']) . '@student.toeflin.com';

        $existing = User::where('email', $dummyEmail)->first();
        if ($existing) {
            return back()
                ->withInput()
                ->withErrors(['nim' => 'Akun dengan Nama dan NIM ini sudah terdaftar. Silakan masuk.']);
        }

        $user = User::create([
            'id'           => Str::uuid()->toString(),
            'name'         => $validated['name'],
            'nim'          => $validated['nim'],
            'fakultas'     => $validated['fakultas'] ?? 'N/A',
            'prodi'        => $validated['prodi'] ?? 'N/A',
            'email'        => $dummyEmail,
            'passwordHash' => Hash::make(Str::random(16)),
            'role'         => 'student',
        ]);

        Auth::login($user, true);
        return redirect()->route('student.dashboard');
    }

    // ─── ADMIN ────────────────────────────────────────────────────────────────

    public function showAdminLogin()
    {
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.admin-login');
    }

    public function adminLogin(Request $request)
    {
        $validated = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $validated['email'])
                    ->whereIn('role', ['admin', 'superadmin'])
                    ->first();

        if (!$user || !Hash::check($validated['password'], $user->passwordHash)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['password' => 'Email atau password salah.']);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    // ─── LOGOUT ───────────────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        $isAdmin = Auth::check() && in_array(Auth::user()->role, ['admin', 'superadmin']);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect($isAdmin ? route('admin.login') : route('student.login'));
    }
}
