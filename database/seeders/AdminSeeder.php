<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Gunakan updateOrCreate agar aman di production
        // Tidak menghapus user/siswa yang sudah ada
        $user = User::updateOrCreate(
            ['email' => 'admin@toeflin.com'],
            [
                'id'           => \Illuminate\Support\Str::uuid()->toString(),
                'name'         => 'Super Admin',
                'passwordHash' => Hash::make('admin123'),
                'role'         => 'superadmin',
                'nim'          => '-',
                'fakultas'     => '-',
                'prodi'        => '-',
            ]
        );

        // Jika record sudah ada, hanya update password dan role
        if (!$user->wasRecentlyCreated) {
            $user->passwordHash = Hash::make('admin123');
            $user->role = 'superadmin';
            // Pastikan id ada (untuk server lama yang mungkin tidak punya)
            if (!$user->id) {
                $user->id = \Illuminate\Support\Str::uuid()->toString();
            }
            $user->save();
        }

        $this->command->info('✅ Superadmin siap: admin@toeflin.com / admin123');
    }
}
