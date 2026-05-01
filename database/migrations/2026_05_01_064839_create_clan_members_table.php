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
        Schema::create('clan_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clan_id')->constrained('clans')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('role')->default('member'); // leader, co_leader, member
            $table->timestamps();
            
            $table->unique(['clan_id', 'user_id']); // A user can only be in a clan once
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clan_members');
    }
};
