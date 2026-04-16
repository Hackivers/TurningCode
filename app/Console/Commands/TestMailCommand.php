<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class TestMailCommand extends Command
{
    protected $signature = 'mail:test {email?}';
    protected $description = 'Send a test email to verify SMTP configuration';

    public function handle(): int
    {
        $recipient = $this->argument('email') ?? config('mail.from.address');

        $this->info("Sending test email to: {$recipient}");
        $this->info('MAIL_MAILER: ' . config('mail.default'));
        $this->info('MAIL_HOST: ' . config('mail.mailers.smtp.host'));
        $this->info('MAIL_PORT: ' . config('mail.mailers.smtp.port'));
        $this->info('MAIL_SCHEME: ' . (config('mail.mailers.smtp.scheme') ?? '(null)'));
        $this->info('MAIL_USERNAME: ' . config('mail.mailers.smtp.username'));
        $this->info('MAIL_FROM: ' . config('mail.from.address'));

        try {
            Mail::html(
                '<h1>Test Email TurningCode</h1><p>Konfigurasi SMTP berhasil! Email ini dikirim dari artisan command <code>mail:test</code>.</p>',
                function ($message) use ($recipient) {
                    $message->to($recipient)
                        ->from(config('mail.from.address'), config('mail.from.name'))
                        ->subject('Test Email - TurningCode SMTP');
                }
            );

            $this->info('✅ Email berhasil dikirim!');
            Log::info('Test email sent successfully', ['recipient' => $recipient]);

            return 0;
        } catch (\Throwable $e) {
            $this->error('❌ Gagal mengirim email: ' . $e->getMessage());
            Log::error('Test email failed', [
                'recipient' => $recipient,
                'error' => $e->getMessage(),
            ]);

            return 1;
        }
    }
}
