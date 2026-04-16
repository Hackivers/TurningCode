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
    public array $backoff = [10, 30, 60];
    public int $timeout = 60;

    public function __construct(
        public string $recipient,
        public string $code,
    ) {}

    public function handle(): void
    {
        Mail::html(
            $this->buildHtmlBody(),
            function ($message) {
                $message->to($this->recipient)
                    ->from(
                        config('mail.from.address'),
                        config('mail.from.name'),
                    )
                    ->subject('Kode Login Admin TurningCode');
            }
        );

        Log::info('Admin OTP email sent successfully', [
            'recipient' => $this->recipient,
        ]);
    }

    /**
     * Build a simple HTML email body for better deliverability.
     */
    private function buildHtmlBody(): string
    {
        return <<<HTML
        <div style="font-family:Arial,sans-serif;max-width:480px;margin:0 auto;padding:20px;">
            <h2 style="color:#4f46e5;">TurningCode — Kode Login Admin</h2>
            <p>Gunakan kode berikut untuk masuk ke dashboard admin:</p>
            <div style="background:#f3f4f6;border-radius:8px;padding:16px;text-align:center;margin:24px 0;">
                <span style="font-size:32px;font-weight:bold;letter-spacing:8px;color:#111827;">{$this->code}</span>
            </div>
            <p style="color:#6b7280;font-size:14px;">Kode ini berlaku selama <strong>10 menit</strong>. Jika Anda tidak merasa meminta kode ini, abaikan email ini.</p>
            <hr style="border:none;border-top:1px solid #e5e7eb;margin:24px 0;">
            <p style="color:#9ca3af;font-size:12px;text-align:center;">© TurningCode — Email otomatis, jangan balas.</p>
        </div>
        HTML;
    }

    /**
     * Handle job failure — log it, don't crash the app.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Failed to send admin OTP email', [
            'recipient' => $this->recipient,
            'error'     => $exception->getMessage(),
            'trace'     => $exception->getTraceAsString(),
        ]);
    }
}

