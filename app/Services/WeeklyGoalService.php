<?php

namespace App\Services;

use App\Models\WeeklyGoal;
use App\Models\User;
use Carbon\Carbon;

class WeeklyGoalService
{
    /**
     * Generate weekly goals for a user
     */
    public function generateWeeklyGoals(User $user): array
    {
        $weekStart = Carbon::now()->startOfWeek();
        $goals = [];

        // Check if goals already exist for this week
        $existingCount = WeeklyGoal::where('user_id', $user->id)
            ->where('week_start', $weekStart)
            ->count();

        if ($existingCount >= 3) {
            return WeeklyGoal::where('user_id', $user->id)
                ->where('week_start', $weekStart)
                ->get()
                ->toArray();
        }

        // Generate default weekly goals
        $goalTypes = ['study_hours', 'resources_completed', 'streak_days'];

        foreach ($goalTypes as $type) {
            $goals[] = $this->createGoal($user, $weekStart, $type);
        }

        return $goals;
    }

    /**
     * Create a single weekly goal
     */
    protected function createGoal(User $user, Carbon $weekStart, string $type): WeeklyGoal
    {
        $config = WeeklyGoal::TYPES[$type];
        $target = $this->calculateTarget($type, $user);

        return WeeklyGoal::create([
            'user_id' => $user->id,
            'week_start' => $weekStart,
            'type' => $type,
            'title' => $config['title'],
            'target_value' => $target,
            'xp_reward' => $this->calculateXpReward($type, $target),
        ]);
    }

    /**
     * Calculate target value based on user history
     */
    protected function calculateTarget(string $type, User $user): int
    {
        $config = WeeklyGoal::TYPES[$type];
        $baseTarget = $config['default_target'];
        
        // Adjust based on user level
        $levelBonus = 1 + ($user->level * 0.05);
        
        return intval($baseTarget * $levelBonus);
    }

    /**
     * Calculate XP reward
     */
    protected function calculateXpReward(string $type, int $target): int
    {
        $baseXp = match ($type) {
            'study_hours' => 20,
            'resources_completed' => 15,
            'topics_completed' => 50,
            'streak_days' => 30,
            'focus_sessions' => 10,
            default => 15,
        };

        return $baseXp * $target;
    }

    /**
     * Update goal progress based on events
     */
    public function updateProgress(User $user, string $eventType, int $amount = 1): void
    {
        $weekStart = Carbon::now()->startOfWeek();
        
        $goals = WeeklyGoal::where('user_id', $user->id)
            ->where('week_start', $weekStart)
            ->where('is_completed', false)
            ->get();

        foreach ($goals as $goal) {
            $shouldUpdate = match ($goal->type) {
                'study_hours' => $eventType === 'time_logged',
                'resources_completed' => $eventType === 'resource_completed',
                'topics_completed' => $eventType === 'topic_completed',
                'streak_days' => $eventType === 'streak_updated',
                'focus_sessions' => $eventType === 'focus_session_completed',
                default => false,
            };

            if ($shouldUpdate) {
                $goal->incrementProgress($amount);
            }
        }
    }

    /**
     * Get current week's goals for a user
     */
    public function getCurrentWeekGoals(User $user): \Illuminate\Database\Eloquent\Collection
    {
        $weekStart = Carbon::now()->startOfWeek();
        
        return WeeklyGoal::where('user_id', $user->id)
            ->where('week_start', $weekStart)
            ->get();
    }

    /**
     * Get goals summary for a user
     */
    public function getGoalsSummary(User $user): array
    {
        $weekStart = Carbon::now()->startOfWeek();
        $goals = $this->getCurrentWeekGoals($user);

        return [
            'total' => $goals->count(),
            'completed' => $goals->where('is_completed', true)->count(),
            'in_progress' => $goals->where('is_completed', false)->count(),
            'total_xp_available' => $goals->sum('xp_reward'),
            'xp_earned' => $goals->where('is_completed', true)->sum('xp_reward'),
            'overall_progress' => $goals->count() > 0 
                ? intval($goals->avg('progress_percentage')) 
                : 0,
        ];
    }
}
