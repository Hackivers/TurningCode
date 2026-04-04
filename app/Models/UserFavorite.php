<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFavorite extends Model
{
    protected $fillable = [
        'user_id',
        'favoritable_type',
        'favoritable_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Ambil array ID favorit user berdasarkan type.
     */
    public static function getIds(int $userId, string $type): array
    {
        return static::where('user_id', $userId)
            ->where('favoritable_type', $type)
            ->pluck('favoritable_id')
            ->toArray();
    }

    /**
     * Toggle favorit: jika sudah ada → hapus, jika belum → buat.
     * Return: ['is_favorited' => bool]
     */
    public static function toggle(int $userId, string $type, int $id): array
    {
        $existing = static::where('user_id', $userId)
            ->where('favoritable_type', $type)
            ->where('favoritable_id', $id)
            ->first();

        if ($existing) {
            $existing->delete();
            return ['is_favorited' => false];
        }

        static::create([
            'user_id'          => $userId,
            'favoritable_type' => $type,
            'favoritable_id'   => $id,
        ]);

        return ['is_favorited' => true];
    }
}
