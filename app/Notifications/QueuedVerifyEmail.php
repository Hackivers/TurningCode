<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;

/**
 * Queued version of Laravel's built-in VerifyEmail notification.
 * This prevents the registration/resend flow from blocking
 * while waiting for SMTP (especially on Railway where port 587 may timeout).
 */
class QueuedVerifyEmail extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public array $backoff = [10, 30, 60];
    public int $timeout = 60;

    /**
     * Handle job failure — log it for debugging.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Failed to send verification email', [
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}

