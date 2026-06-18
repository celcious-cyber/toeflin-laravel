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
        Schema::table('test_packages', function (Blueprint $table) {
            $table->text('instruction_listening')->nullable();
            $table->text('instruction_structure')->nullable();
            $table->text('instruction_reading')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_packages', function (Blueprint $table) {
            $table->dropColumn(['instruction_listening', 'instruction_structure', 'instruction_reading']);
        });
    }
};
