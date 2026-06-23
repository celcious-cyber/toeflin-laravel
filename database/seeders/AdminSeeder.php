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
        // Hapus semua user lama (termasuk yang double-hashed)
        User::query()->delete();

        // Buat superadmin baru dengan password yang benar
        User::create([
            'id' => Str::uuid()->toString(),
            'name' => 'Super Admin',
            'email' => 'admin@toeflin.com',
            'passwordHash' => Hash::make('admin123'),
            'role' => 'superadmin',
            'nim' => '-',
            'fakultas' => '-',
            'prodi' => '-',
        ]);

        $this->command->info('✅ Superadmin berhasil dibuat: admin@toeflin.com / admin123');
    }
}
