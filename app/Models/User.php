<?php

namespace App\Models;

use App\Notifications\QueuedVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'last_seen', 'last_page', 'avatar', 'exp'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_seen' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Send the email verification notification via queue.
     * Prevents HTTP response from blocking while waiting for SMTP.
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new QueuedVerifyEmail);
    }

    public function friendRequestsSent()
    {
        return $this->hasMany(Friendship::class, 'user_id')->where('status', 'pending');
    }

    public function friendRequestsReceived()
    {
        return $this->hasMany(Friendship::class, 'friend_id')->where('status', 'pending');
    }

    public function getFriendsAttribute()
    {
        $initiated = Friendship::where('user_id', $this->id)->where('status', 'accepted')->pluck('friend_id');
        $received = Friendship::where('friend_id', $this->id)->where('status', 'accepted')->pluck('user_id');
        $friendIds = $initiated->merge($received)->unique();
        
        return User::whereIn('id', $friendIds)->get();
    }

    public function getRankNameAttribute(): string
    {
        $exp = $this->exp ?? 0;
        if ($exp >= 1000000) return 'Penguasa Sektor';
        if ($exp >= 500000) return 'Venerable';
        if ($exp >= 250000) return 'Immortal';
        if ($exp >= 100000) return 'Domain';
        if ($exp >= 80000) return 'Universe';
        if ($exp >= 40000) return 'Legend';
        if ($exp >= 20000) return 'Grandmaster';
        if ($exp >= 10000) return 'Master';
        if ($exp >= 5000) return 'Senior';
        if ($exp >= 1000) return 'Junior';
        return 'Pemula';
    }

    /**
     * Check if user is Elite tier (above Legend: Universe+).
     */
    public function isElite(): bool
    {
        return ($this->exp ?? 0) >= 80000;
    }

    /**
     * Check if user is Penguasa Sektor (Sovereign Tier).
     */
    public function isPenguasaSektor(): bool
    {
        return ($this->exp ?? 0) >= 1000000;
    }

    /**
     * Get the elite tier number (0 = not elite, 1-5 = Universe to Penguasa Sektor).
     */
    public function getEliteTierAttribute(): int
    {
        $exp = $this->exp ?? 0;
        if ($exp >= 1000000) return 5; // Penguasa Sektor
        if ($exp >= 500000) return 4;  // Venerable
        if ($exp >= 250000) return 3;  // Immortal
        if ($exp >= 100000) return 2;  // Domain
        if ($exp >= 80000) return 1;   // Universe
        return 0;
    }

    public function getEmblemImageAttribute(): string
    {
        $exp = $this->exp ?? 0;
        if ($exp >= 1000000) return 'emblem011Trans.png';
        if ($exp >= 500000) return 'emblem010Trans.png';
        if ($exp >= 250000) return 'emblem009Trans.png';
        if ($exp >= 100000) return 'emblem008Trans.png';
        if ($exp >= 80000) return 'emblem007Trans.png';
        if ($exp >= 40000) return 'emblem006Trans.png';
        if ($exp >= 20000) return 'emblem005Trans.png';
        if ($exp >= 10000) return 'emblem004Trans.png';
        if ($exp >= 5000) return 'emblem003Trans.png';
        if ($exp >= 1000) return 'emblem002Trans.png';
        return 'emblem001Trans.png';
    }

    public function getNextRankNameAttribute(): ?string
    {
        $exp = $this->exp ?? 0;
        if ($exp < 1000) return 'Junior';
        if ($exp < 5000) return 'Senior';
        if ($exp < 10000) return 'Master';
        if ($exp < 20000) return 'Grandmaster';
        if ($exp < 40000) return 'Legend';
        if ($exp < 80000) return 'Universe';
        if ($exp < 100000) return 'Domain';
        if ($exp < 250000) return 'Immortal';
        if ($exp < 500000) return 'Venerable';
        if ($exp < 1000000) return 'Penguasa Sektor';
        return null; // Max rank reached
    }

    public function getNextRankExpAttribute(): ?int
    {
        $exp = $this->exp ?? 0;
        if ($exp < 1000) return 1000;
        if ($exp < 5000) return 5000;
        if ($exp < 10000) return 10000;
        if ($exp < 20000) return 20000;
        if ($exp < 40000) return 40000;
        if ($exp < 80000) return 80000;
        if ($exp < 100000) return 100000;
        if ($exp < 250000) return 250000;
        if ($exp < 500000) return 500000;
        if ($exp < 1000000) return 1000000;
        return null; // Max rank reached
    }
}

