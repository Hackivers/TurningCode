<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Polymorphic: favorite bisa materi atau sub_materi
            $table->string('favoritable_type', 50); // 'materi' atau 'sub'
            $table->unsignedBigInteger('favoritable_id');

            $table->timestamps();

            $table->unique(['user_id', 'favoritable_type', 'favoritable_id'], 'user_fav_unique');
            $table->index(['user_id', 'favoritable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_favorites');
    }
};
