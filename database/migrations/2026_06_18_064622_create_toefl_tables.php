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
        Schema::create('audios', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('fileUrl', 255);
            $table->text('transcript')->nullable();
        });

        Schema::create('passages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 255);
            $table->text('content');
        });

        Schema::create('test_packages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 255);
            $table->string('type', 255);
            $table->text('questions');
            $table->text('durations');
            $table->string('status', 255)->default('draft');
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('section', 255);
            $table->string('skillCategory', 255)->nullable();
            $table->text('content');
            $table->text('choices');
            $table->string('answerKey', 255);
            $table->text('explanation')->nullable();
            $table->string('audioId', 255)->nullable();
            $table->string('passageId', 255)->nullable();
            $table->string('packageId', 255)->nullable();
        });

        Schema::create('score_conversions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('section', 255);
            $table->integer('rawScore');
            $table->integer('scaledScore');
        });

        Schema::create('test_attempts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('userId', 255);
            $table->string('packageId', 255);
            $table->dateTime('date', 6)->useCurrent();
            $table->integer('durationSeconds');
            $table->text('answers');
            $table->text('rawScores')->nullable();
            $table->text('scaledScores')->nullable();
            $table->integer('totalScore')->nullable();
        });

        Schema::create('test_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('userId', 255);
            $table->string('packageId', 255);
            $table->string('status', 20)->default('PENDING');
            $table->dateTime('createdAt', 6)->useCurrent();
            $table->dateTime('updatedAt', 6)->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_requests');
        Schema::dropIfExists('test_attempts');
        Schema::dropIfExists('score_conversions');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('test_packages');
        Schema::dropIfExists('passages');
        Schema::dropIfExists('audios');
    }
};
