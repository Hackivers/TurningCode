<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\User;
use App\Models\UserAchievement;
use App\Models\UserHistory;
use App\Models\UserFavorite;
use App\Models\StudySchedule;
use App\Models\QuizAttempt;
use App\Models\Friendship;
use App\Models\Discussion;
use App\Models\UserMission;

class AchievementService
{
    /**
     * Check all achievements and award any that the user qualifies for.
     * Returns array of newly earned achievements.
     */
    public function checkAndAward(User $user): array
    {
        $allAchievements = Achievement::all();
        $earnedIds = UserAchievement::where('user_id', $user->id)
            ->pluck('achievement_id')
            ->toArray();

        $newlyEarned = [];

        foreach ($allAchievements as $achievement) {
            if (in_array($achievement->id, $earnedIds)) {
                continue;
            }

            if ($this->meetsRequirements($user, $achievement)) {
                UserAchievement::create([
                    'user_id'        => $user->id,
                    'achievement_id' => $achievement->id,
                    'earned_at'      => now(),
                ]);

                // Award bonus EXP
                if ($achievement->exp_reward > 0) {
                    $user->exp += $achievement->exp_reward;
                    $user->save();
                }

                $newlyEarned[] = $achievement;
            }
        }

        return $newlyEarned;
    }

    /**
     * Check if user meets the criteria for a specific achievement.
     */
    private function meetsRequirements(User $user, Achievement $achievement): bool
    {
        $value = $achievement->criteria_value;

        return match ($achievement->criteria_type) {
            'history_count' => UserHistory::where('user_id', $user->id)
                ->distinct('sub_materi_id')
                ->count('sub_materi_id') >= $value,

            'fav_count' => UserFavorite::where('user_id', $user->id)->count() >= $value,

            'schedule_count' => StudySchedule::where('user_id', $user->id)->count() >= $value,

            'exp_min' => ($user->exp ?? 0) >= $value,

            'quiz_pass' => QuizAttempt::where('user_id', $user->id)
                ->where('passed', true)
                ->count() >= $value,

            'quiz_perfect' => QuizAttempt::where('user_id', $user->id)
                ->where('score', 100)
                ->exists(),

            'quiz_attempt' => QuizAttempt::where('user_id', $user->id)->count() >= $value,

            'friend_count' => Friendship::where(function ($q) use ($user) {
                    $q->where('user_id', $user->id)->orWhere('friend_id', $user->id);
                })->where('status', 'accepted')->count() >= $value,

            'discussion_count' => Discussion::where('user_id', $user->id)->count() >= $value,

            'mission_complete' => UserMission::where('user_id', $user->id)
                ->where('completed', true)
                ->count() >= $value,

            default => false,
        };
    }
}
