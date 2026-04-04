<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('study_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();

            // Tipe jadwal: daily, weekly, monthly, custom (one-time)
            $table->string('schedule_type', 20)->default('daily');

            // Weekly: hari apa saja (JSON array of 0-6, 0=Minggu)
            $table->json('days_of_week')->nullable();

            // Monthly: tanggal berapa (1-31)
            $table->unsignedTinyInteger('day_of_month')->nullable();

            // Custom: tanggal spesifik
            $table->date('custom_date')->nullable();

            // Jam mulai & selesai
            $table->time('start_time');
            $table->time('end_time')->nullable();

            // Status & warna
            $table->boolean('is_active')->default(true);
            $table->string('color', 20)->default('#6366f1');

            $table->timestamps();

            $table->index(['user_id', 'schedule_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('study_schedules');
    }
};
