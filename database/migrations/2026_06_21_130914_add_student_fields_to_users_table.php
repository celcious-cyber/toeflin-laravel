<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nim', 'fakultas', 'prodi']);
        });
    }
};
