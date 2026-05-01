<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('type');            // 'daily', 'weekly'
            $table->string('action');          // 'quiz_pass', 'read_materi', 'login', 'favorite_add', 'exp_gain'
            $table->unsignedInteger('target'); // Target count
            $table->unsignedInteger('exp_reward')->default(25);
            $table->string('icon')->default('bx-target-lock');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('user_missions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('mission_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('progress')->default(0);
            $table->boolean('completed')->default(false);
            $table->boolean('claimed')->default(false);
            $table->date('assigned_date');
            $table->timestamps();

            $table->unique(['user_id', 'mission_id', 'assigned_date']);
            $table->index(['user_id', 'assigned_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_missions');
        Schema::dropIfExists('missions');
    }
};
