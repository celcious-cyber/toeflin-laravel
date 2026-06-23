<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom remember_token ke tabel users.
     * Kolom ini diperlukan oleh Laravel Auth untuk fitur "remember me"
     * dan juga untuk sesi login yang persisten.
     * Tanpa kolom ini, Auth::login($user, true) akan gagal karena
     * Laravel mencoba menulis remember_token ke database.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken()->nullable()->after('role');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('remember_token');
        });
    }
};
