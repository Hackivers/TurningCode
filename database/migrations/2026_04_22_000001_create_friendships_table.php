<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('friendships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');   // who sent the request
            $table->unsignedBigInteger('friend_id'); // who received the request
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('friend_id')->references('id')->on('users')->onDelete('cascade');

            // Prevent duplicate friendship rows in both directions
            $table->unique(['user_id', 'friend_id']);

            $table->index(['user_id', 'status']);
            $table->index(['friend_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('friendships');
    }
};
