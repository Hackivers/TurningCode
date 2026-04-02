<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_codes', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('code');
            $table->timestamp('expired_at');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('last_seen')->nullable()->after('remember_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_seen');
        });

        Schema::dropIfExists('admin_codes');
    }
};
