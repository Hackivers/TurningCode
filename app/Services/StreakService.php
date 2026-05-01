<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserStreak;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StreakService
{
    /**
     * Check in the user for today's streak.
     * Call this when user does an activity (e.g., login, view materi, finish quiz).
     */
    public function checkIn(User $user)
    {
        try {
            $streak = UserStreak::firstOrCreate(
                ['user_id' => $user->id],
                ['current_streak' => 0, 'longest_streak' => 0, 'last_activity_date' => null, 'streak_shields' => 0]
            );

            $today = Carbon::today();
            $lastActivity = $streak->last_activity_date ? Carbon::parse($streak->last_activity_date)->startOfDay() : null;

            if ($lastActivity && $lastActivity->isToday()) {
                // Already checked in today
                return false;
            }

            $streakBroken = false;
            if ($lastActivity && $lastActivity->diffInDays($today) > 1) {
                // Missed at least one day
                if ($streak->streak_shields > 0) {
                    $streak->streak_shields -= 1;
                    // Shield used, streak continues
                } else {
                    $streakBroken = true;
                }
            }

            if ($streakBroken) {
                $streak->current_streak = 1; // Start new streak
            } else {
                $streak->current_streak += 1;
            }

            if ($streak->current_streak > $streak->longest_streak) {
                $streak->longest_streak = $streak->current_streak;
            }

            $streak->last_activity_date = $today;
            $streak->save();

            // Give milestone rewards
            $this->giveMilestoneReward($user, $streak->current_streak);

            return [
                'current_streak' => $streak->current_streak,
                'streak_broken' => $streakBroken,
            ];
        } catch (\Exception $e) {
            Log::error('StreakService error: ' . $e->getMessage());
            return false;
        }
    }

    private function giveMilestoneReward(User $user, int $currentStreak)
    {
        $rewards = [
            3 => 50,
            7 => 150,
            14 => 400,
            30 => 1000,
            100 => 5000,
            365 => 20000,
        ];

        if (array_key_exists($currentStreak, $rewards)) {
            $user->exp = ($user->exp ?? 0) + $rewards[$currentStreak];
            $user->save();
            
            // Note: In a real app, we might want to notify the user via a session flash or db notification
            session()->flash('streak_reward', [
                'streak' => $currentStreak,
                'exp' => $rewards[$currentStreak]
            ]);
        }
    }

    public function getStreakData(User $user)
    {
        $streak = UserStreak::firstOrCreate(
            ['user_id' => $user->id],
            ['current_streak' => 0, 'longest_streak' => 0, 'last_activity_date' => null, 'streak_shields' => 0]
        );

        $today = Carbon::today();
        $lastActivity = $streak->last_activity_date ? Carbon::parse($streak->last_activity_date)->startOfDay() : null;
        
        $isActiveToday = $lastActivity && $lastActivity->isToday();
        
        // Check if streak is broken but not checked in yet today
        if (!$isActiveToday && $lastActivity && $lastActivity->diffInDays($today) > 1) {
            if ($streak->streak_shields == 0) {
                 // Predict that the current streak is 0 if they haven't checked in
                 // and don't have a shield
                 return [
                     'current_streak' => 0,
                     'longest_streak' => $streak->longest_streak,
                     'is_active_today' => false,
                     'streak_shields' => $streak->streak_shields,
                 ];
            }
        }

        return [
            'current_streak' => $streak->current_streak,
            'longest_streak' => $streak->longest_streak,
            'is_active_today' => $isActiveToday,
            'streak_shields' => $streak->streak_shields,
        ];
    }
}
