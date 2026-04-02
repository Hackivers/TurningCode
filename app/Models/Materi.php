<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materi extends Model
{
    protected $fillable = [
        'main_materi_id',
        'title',
        'description',
    ];

    public function mainMateri(): BelongsTo
    {
        return $this->belongsTo(MainMateri::class);
    }

    public function subMateris(): HasMany
    {
        return $this->hasMany(SubMateri::class);
    }
}
