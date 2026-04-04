<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sub_materi_id')->constrained('sub_materis')->cascadeOnDelete();
            $table->timestamp('viewed_at')->useCurrent();
            $table->timestamps();

            // Unique per user+submateri, supaya tidak duplikat
            $table->unique(['user_id', 'sub_materi_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_histories');
    }
};
