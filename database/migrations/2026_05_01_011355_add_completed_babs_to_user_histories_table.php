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
        Schema::table('user_histories', function (Blueprint $table) {
            $table->json('completed_babs')->nullable()->after('viewed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_histories', function (Blueprint $table) {
            $table->dropColumn('completed_babs');
        });
    }
};
