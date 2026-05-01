<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sub_materi_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('discussions')->cascadeOnDelete();
            $table->text('body');
            $table->unsignedInteger('upvotes')->default(0);
            $table->timestamps();

            $table->index(['sub_materi_id', 'created_at']);
        });

        Schema::create('discussion_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('discussion_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'discussion_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discussion_votes');
        Schema::dropIfExists('discussions');
    }
};
