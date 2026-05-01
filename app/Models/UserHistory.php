<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserHistory extends Model
{
    protected $fillable = [
        'user_id',
        'sub_materi_id',
        'viewed_at',
        'completed_babs',
    ];

    protected function casts(): array
    {
        return [
            'viewed_at' => 'datetime',
            'completed_babs' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function submateri(): BelongsTo
    {
        return $this->belongsTo(SubMateri::class, 'sub_materi_id');
    }
}
