<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpEvent extends Model
{
    protected $fillable = [
        'title',
        'description',
        'multiplier',
        'start_time',
        'end_time',
        'is_active',
    ];

    protected $casts = [
        'multiplier' => 'float',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Check if the event is currently active.
     */
    public function getIsOngoingAttribute()
    {
        return $this->is_active && now()->between($this->start_time, $this->end_time);
    }
}
