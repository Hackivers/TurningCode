<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    protected $fillable = [
        'sub_materi_id',
        'question',
        'code_snippet',
        'code_language',
        'options',
        'correct_option',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'options'        => 'array',
            'correct_option' => 'integer',
            'order'          => 'integer',
        ];
    }

    public function subMateri(): BelongsTo
    {
        return $this->belongsTo(SubMateri::class);
    }
}
