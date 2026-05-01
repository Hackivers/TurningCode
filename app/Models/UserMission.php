<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMission extends Model
{
    protected $fillable = [
        'user_id',
        'mission_id',
        'progress',
        'completed',
        'claimed',
        'assigned_date',
    ];

    protected function casts(): array
    {
        return [
            'progress'      => 'integer',
            'completed'     => 'boolean',
            'claimed'       => 'boolean',
            'assigned_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mission(): BelongsTo
    {
        return $this->belongsTo(Mission::class);
    }
}
