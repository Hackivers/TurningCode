<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('title');
            $table->string('description');
            $table->string('icon');
            $table->string('criteria_type');       // 'history_count', 'fav_count', 'exp_min', 'quiz_pass', 'quiz_perfect', 'friend_count', 'discussion_count', 'mission_complete'
            $table->unsignedInteger('criteria_value');
            $table->unsignedInteger('exp_reward')->default(0);
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });

        Schema::create('user_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('achievement_id')->constrained()->cascadeOnDelete();
            $table->timestamp('earned_at');
            $table->timestamps();

            $table->unique(['user_id', 'achievement_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_achievements');
        Schema::dropIfExists('achievements');
    }
};
