<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Materi;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Support\Str;

class CertificateService
{
    /**
     * Check if a user has completed all quizzes in a materi and passed them.
     * If so, issue a certificate.
     */
    public function checkAndIssue(User $user, $materiId)
    {
        // Get all sub materis for this materi
        $materi = Materi::with('subMateris')->find($materiId);
        if (!$materi) return false;

        $subMateriIds = $materi->subMateris->pluck('id')->toArray();
        if (empty($subMateriIds)) return false; // No sub materis

        // Check if user has passed all sub materis
        $passedAttemptsCount = QuizAttempt::where('user_id', $user->id)
            ->whereIn('sub_materi_id', $subMateriIds)
            ->where('passed', true)
            ->distinct('sub_materi_id')
            ->count('sub_materi_id');

        if ($passedAttemptsCount >= count($subMateriIds)) {
            // Check if already has certificate
            $existing = Certificate::where('user_id', $user->id)
                ->where('materi_id', $materiId)
                ->first();

            if (!$existing) {
                // Issue certificate
                $code = 'TC-' . date('Y') . '-' . strtoupper(Str::random(6));
                
                $cert = Certificate::create([
                    'user_id' => $user->id,
                    'materi_id' => $materiId,
                    'certificate_code' => $code,
                    'issued_at' => now(),
                ]);

                // Bonus EXP for completing a materi completely
                $user->exp += 200;
                $user->save();

                return $cert;
            }
            return $existing;
        }

        return false;
    }
}
