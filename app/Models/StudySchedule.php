<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudySchedule extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'schedule_type',
        'days_of_week',
        'day_of_month',
        'custom_date',
        'start_time',
        'end_time',
        'is_active',
        'color',
    ];

    protected function casts(): array
    {
        return [
            'days_of_week' => 'array',
            'custom_date'  => 'date',
            'is_active'    => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Cek apakah jadwal aktif hari ini.
     */
    public function isActiveToday(): bool
    {
        if (! $this->is_active) return false;

        $today    = now();
        $dayOfWeek = (int) $today->dayOfWeek; // 0=Sun, 6=Sat

        return match ($this->schedule_type) {
            'daily'   => true,
            'weekly'  => in_array($dayOfWeek, $this->days_of_week ?? []),
            'monthly' => $today->day === $this->day_of_month,
            'custom'  => $this->custom_date && $today->isSameDay($this->custom_date),
            default   => false,
        };
    }

    /**
     * Label hari untuk tampilan.
     */
    public function getScheduleLabel(): string
    {
        $dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

        return match ($this->schedule_type) {
            'daily'   => 'Setiap hari',
            'weekly'  => 'Tiap ' . collect($this->days_of_week ?? [])
                            ->map(fn($d) => $dayNames[$d] ?? '?')
                            ->join(', '),
            'monthly' => 'Tanggal ' . $this->day_of_month . ' tiap bulan',
            'custom'  => $this->custom_date?->translatedFormat('d M Y') ?? '-',
            default   => '-',
        };
    }
}
