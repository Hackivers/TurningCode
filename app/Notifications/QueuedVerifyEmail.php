<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

/**
 * Queued version of Laravel's built-in VerifyEmail notification.
 * This prevents the registration/resend flow from blocking
 * while waiting for SMTP (especially on Railway where port 587 may timeout).
 */
class QueuedVerifyEmail extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 30;
    public int $timeout = 60;
}
