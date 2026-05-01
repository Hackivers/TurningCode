<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discussion extends Model
{
    protected $fillable = [
        'user_id',
        'sub_materi_id',
        'parent_id',
        'body',
        'upvotes',
    ];

    protected function casts(): array
    {
        return [
            'upvotes' => 'integer',
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

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Discussion::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Discussion::class, 'parent_id')->orderBy('created_at');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(DiscussionVote::class);
    }
}
