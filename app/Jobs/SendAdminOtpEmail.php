<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendAdminOtpEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Retry up to 3 times with 30 second backoff.
     */
    public int $tries = 3;
    public int $backoff = 30;
    public int $timeout = 60;

    public function __construct(
        public string $recipient,
        public string $code,
    ) {}

    public function handle(): void
    {
        Mail::raw("Kode login admin Anda: {$this->code}", function ($message) {
            $message->to($this->recipient)
                ->subject('Kode Login Admin TurningCode');
        });
    }

    /**
     * Handle job failure — log it, don't crash the app.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Failed to send admin OTP email', [
            'recipient' => $this->recipient,
            'error'     => $exception->getMessage(),
        ]);
    }
}
