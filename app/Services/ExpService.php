<?php

namespace App\Services;

use App\Models\ExpEvent;
use App\Models\User;

class ExpService
{
    /**
     * Calculate and apply EXP to user considering ongoing EXP events.
     *
     * @param User $user The user to receive EXP
     * @param float|int $baseExp The base EXP amount
     * @return int The actual EXP gained after multipliers
     */
    public function addExp(User $user, $baseExp): int
    {
        $multiplier = 1.0;

        // Check for active ongoing events
        $activeEvents = ExpEvent::where('is_active', true)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->get();

        // Stack multipliers (additive or multiplicative? We'll take the max multiplier or additive)
        // Let's take the max multiplier to prevent insane EXP stacking
        if ($activeEvents->isNotEmpty()) {
            $maxEventMultiplier = $activeEvents->max('multiplier');
            if ($maxEventMultiplier > $multiplier) {
                $multiplier = $maxEventMultiplier;
            }
        }

        $finalExp = (int) round($baseExp * $multiplier);

        $user->exp += $finalExp;
        $user->save();

        return $finalExp;
    }

    /**
     * Get the current active max multiplier.
     */
    public function getCurrentMultiplier(): float
    {
        $activeEvent = ExpEvent::where('is_active', true)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->orderByDesc('multiplier')
            ->first();

        return $activeEvent ? (float) $activeEvent->multiplier : 1.0;
    }
}
