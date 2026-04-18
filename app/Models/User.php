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

#[Fillable(['name', 'email', 'password', 'role', 'last_seen', 'avatar', 'exp'])]
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

    public function getRankNameAttribute(): string
    {
        $exp = $this->exp ?? 0;
        if ($exp >= 20000) return 'Legend';
        if ($exp >= 10000) return 'Master';
        if ($exp >= 5000) return 'Senior';
        if ($exp >= 1000) return 'Junior';
        return 'Pemula';
    }

    public function getEmblemImageAttribute(): string
    {
        $exp = $this->exp ?? 0;
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
        if ($exp < 20000) return 'Legend';
        return null; // Max rank reached
    }

    public function getNextRankExpAttribute(): ?int
    {
        $exp = $this->exp ?? 0;
        if ($exp < 1000) return 1000;
        if ($exp < 5000) return 5000;
        if ($exp < 10000) return 10000;
        if ($exp < 20000) return 20000;
        return null; // Max rank reached
    }
}

