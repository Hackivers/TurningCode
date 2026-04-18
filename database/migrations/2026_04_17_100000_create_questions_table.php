<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_materi_id')->constrained('sub_materis')->cascadeOnDelete();
            $table->text('question');
            $table->json('options');          // ["Opsi A", "Opsi B", "Opsi C", "Opsi D"]
            $table->tinyInteger('correct_option'); // 0-3
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();

            $table->index('sub_materi_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
