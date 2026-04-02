<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MainMateri extends Model
{
    protected $fillable = [
        'title',
        'description',
    ];

    public function materis(): HasMany
    {
        return $this->hasMany(Materi::class);
    }
}
