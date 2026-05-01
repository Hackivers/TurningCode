<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNote extends Model
{
    protected $fillable = [
        'user_id',
        'sub_materi_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subMateri()
    {
        return $this->belongsTo(SubMateri::class);
    }
}
