<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Achievement extends Model
{
    protected $fillable = [
        'key',
        'title',
        'description',
        'icon',
        'criteria_type',
        'criteria_value',
        'exp_reward',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'criteria_value' => 'integer',
            'exp_reward'     => 'integer',
            'order'          => 'integer',
        ];
    }

    public function userAchievements(): HasMany
    {
        return $this->hasMany(UserAchievement::class);
    }
}
