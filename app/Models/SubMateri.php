<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubMateri extends Model
{
    protected $fillable = [
        'materi_id',
        'sections',
        'sections_json',
    ];

    protected function casts(): array
    {
        return [
            'sections' => 'array',
        ];
    }

    public function materi(): BelongsTo
    {
        return $this->belongsTo(Materi::class);
    }

    /**
     * String JSON terformat (sama dengan kolom sections_json).
     */
    public function getSectionsAsFormattedString(): string
    {
        return json_encode($this->sections, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?: '';
    }
}
