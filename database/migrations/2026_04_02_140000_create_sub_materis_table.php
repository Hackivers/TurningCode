<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_materis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materi_id')->constrained('materis')->cascadeOnDelete();
            $table->json('sections');
            $table->longText('sections_json')->comment('Salinan string JSON (UTF-8) untuk baca/export');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_materis');
    }
};
