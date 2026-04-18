<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sub_materi_id')->constrained('sub_materis')->cascadeOnDelete();
            $table->unsignedTinyInteger('score')->default(0);   // 0-100
            $table->json('answers')->nullable();                // { "1": 2, "3": 0, ... }
            $table->boolean('passed')->default(false);
            $table->boolean('exp_awarded')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'sub_materi_id']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};
