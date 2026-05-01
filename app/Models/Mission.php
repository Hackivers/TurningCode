<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mission extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'action',
        'target',
        'exp_reward',
        'icon',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'target'     => 'integer',
            'exp_reward' => 'integer',
            'is_active'  => 'boolean',
        ];
    }

    public function userMissions(): HasMany
    {
        return $this->hasMany(UserMission::class);
    }
}
