<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'sub_materi_id',
        'score',
        'answers',
        'passed',
        'exp_awarded',
    ];

    protected function casts(): array
    {
        return [
            'answers'     => 'array',
            'score'       => 'integer',
            'passed'      => 'boolean',
            'exp_awarded' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subMateri(): BelongsTo
    {
        return $this->belongsTo(SubMateri::class);
    }
}
