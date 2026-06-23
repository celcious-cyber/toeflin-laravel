<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function quickJoin(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'max:50'],
        ]);

        // Cari apakah user dengan nama dan nim ini sudah ada (agar bisa melanjutkan ujian jika terputus)
        // Gunakan email dummy berbasis nama dan nim agar unik
        $dummyEmail = Str::slug($validated['name'] . ' ' . $validated['nim']) . '@student.toeflin.com';

        $user = User::where('email', $dummyEmail)->first();

        if (!$user) {
            $user = User::create([
                'id' => Str::uuid()->toString(),
                'name' => $validated['name'],
                'nim' => $validated['nim'],
                'fakultas' => 'N/A',
                'prodi' => 'N/A',
                'email' => $dummyEmail,
                'passwordHash' => Hash::make(Str::random(16)),
                'role' => 'student',
            ]);
        }

        Auth::login($user, true); // login dan remember
        
        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
