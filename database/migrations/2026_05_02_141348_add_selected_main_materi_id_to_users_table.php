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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('selected_main_materi_id')->nullable()->after('role');
            $table->foreign('selected_main_materi_id')->references('id')->on('main_materis')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['selected_main_materi_id']);
            $table->dropColumn('selected_main_materi_id');
        });
    }
};
