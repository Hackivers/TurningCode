<?php

namespace App\Services;

use App\Models\Mission;
use App\Models\User;
use App\Models\UserMission;
use Carbon\Carbon;

class MissionService
{
    /**
     * Assign daily missions to a user for today.
     * Picks 3 random active daily missions that haven't been assigned yet.
     */
    public function assignDailyMissions(User $user): void
    {
        $today = Carbon::today();

        // Already assigned today? Skip.
        $existingCount = UserMission::where('user_id', $user->id)
            ->where('assigned_date', $today)
            ->whereHas('mission', fn($q) => $q->where('type', 'daily'))
            ->count();

        if ($existingCount >= 3) {
            return;
        }

        $dailyMissions = Mission::where('type', 'daily')
            ->where('is_active', true)
            ->inRandomOrder()
            ->limit(3 - $existingCount)
            ->get();

        foreach ($dailyMissions as $mission) {
            UserMission::firstOrCreate([
                'user_id'       => $user->id,
                'mission_id'    => $mission->id,
                'assigned_date' => $today,
            ], [
                'progress'  => 0,
                'completed' => false,
                'claimed'   => false,
            ]);
        }
    }

    /**
     * Assign weekly missions to a user for this week (Monday).
     */
    public function assignWeeklyMissions(User $user): void
    {
        $weekStart = Carbon::now()->startOfWeek();

        $existingCount = UserMission::where('user_id', $user->id)
            ->where('assigned_date', $weekStart)
            ->whereHas('mission', fn($q) => $q->where('type', 'weekly'))
            ->count();

        if ($existingCount >= 2) {
            return;
        }

        $weeklyMissions = Mission::where('type', 'weekly')
            ->where('is_active', true)
            ->inRandomOrder()
            ->limit(2 - $existingCount)
            ->get();

        foreach ($weeklyMissions as $mission) {
            UserMission::firstOrCreate([
                'user_id'       => $user->id,
                'mission_id'    => $mission->id,
                'assigned_date' => $weekStart,
            ], [
                'progress'  => 0,
                'completed' => false,
                'claimed'   => false,
            ]);
        }
    }

    /**
     * Track progress for a specific action type.
     * Called after user performs an action (quiz pass, read materi, etc.).
     */
    public function trackProgress(User $user, string $action, int $increment = 1): void
    {
        $today = Carbon::today();
        $weekStart = Carbon::now()->startOfWeek();

        // Get all active (non-claimed) missions for this user matching the action
        $userMissions = UserMission::where('user_id', $user->id)
            ->where('claimed', false)
            ->where(function ($q) use ($today, $weekStart) {
                $q->where('assigned_date', $today)
                  ->orWhere('assigned_date', $weekStart);
            })
            ->whereHas('mission', fn($q) => $q->where('action', $action))
            ->with('mission')
            ->get();

        foreach ($userMissions as $um) {
            if ($um->completed) {
                continue;
            }

            $um->progress = min($um->progress + $increment, $um->mission->target);
            $um->completed = $um->progress >= $um->mission->target;
            $um->save();
        }
    }

    /**
     * Claim EXP reward for a completed mission.
     */
    public function claimReward(User $user, UserMission $userMission): array
    {
        if ($userMission->user_id !== $user->id) {
            return ['success' => false, 'message' => 'Misi tidak ditemukan.'];
        }

        if (!$userMission->completed) {
            return ['success' => false, 'message' => 'Misi belum selesai.'];
        }

        if ($userMission->claimed) {
            return ['success' => false, 'message' => 'Reward sudah diklaim.'];
        }

        $reward = $userMission->mission->exp_reward;

        $user->exp += $reward;
        $user->save();

        $userMission->claimed = true;
        $userMission->save();

        return [
            'success'    => true,
            'message'    => "Reward +{$reward} EXP berhasil diklaim! 🎉",
            'exp_gained' => $reward,
            'new_exp'    => $user->exp,
        ];
    }
}
