<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class GamificationService
{
    /**
     * Calculate user's current learning streak
     */
    public function calculateStreak(User $user): int
    {
        $activities = $user->activityLogs()
            ->where('created_at', '>=', now()->subYear())
            ->orderBy('created_at', 'desc')
            ->pluck('created_at')
            ->map(fn($date) => $date->format('Y-m-d'))
            ->unique()
            ->values();

        if ($activities->isEmpty()) {
            return 0;
        }

        $streak = 0;
        $currentDate = now();

        foreach ($activities as $activityDate) {
            $checkDate = $currentDate->format('Y-m-d');

            if ($activityDate === $checkDate) {
                $streak++;
                $currentDate->subDay();
            } else {
                break;
            }
        }

        return $streak;
    }

    /**
     * Get user's achievements
     */
    public function getAchievements(User $user): array
    {
        $roadmapsCount = $user->roadmaps()->count();
        $topicsCompleted = $user->topicProgress()->whereNotNull('completed_at')->count();
        $timeSpentHours = $user->topicProgress()->sum('time_spent') / 60;
        $certificatesCount = $user->certificates()->count();
        $resourcesCompleted = $user->resources()->where('is_completed', true)->count();
        $streak = $this->calculateStreak($user);

        return [
            'first_steps' => [
                'unlocked' => $roadmapsCount >= 1,
                'title' => 'First Steps',
                'description' => 'Create your first roadmap',
                'icon' => '🎯',
                'progress' => min($roadmapsCount, 1),
                'total' => 1,
            ],
            'dedicated_learner' => [
                'unlocked' => $topicsCompleted >= 10,
                'title' => 'Dedicated Learner',
                'description' => 'Complete 10 topics',
                'icon' => '📚',
                'progress' => $topicsCompleted,
                'total' => 10,
            ],
            'marathon_runner' => [
                'unlocked' => $timeSpentHours >= 100,
                'title' => 'Marathon Runner',
                'description' => 'Spend 100 hours learning',
                'icon' => '⏰',
                'progress' => round($timeSpentHours, 1),
                'total' => 100,
            ],
            'completionist' => [
                'unlocked' => $certificatesCount >= 1,
                'title' => 'Completionist',
                'description' => 'Earn your first certificate',
                'icon' => '🏆',
                'progress' => $certificatesCount,
                'total' => 1,
            ],
            'speed_demon' => [
                'unlocked' => $this->hasCompletedRoadmapIn30Days($user),
                'title' => 'Speed Demon',
                'description' => 'Complete roadmap in under 30 days',
                'icon' => '⚡',
                'progress' => $this->hasCompletedRoadmapIn30Days($user) ? 1 : 0,
                'total' => 1,
            ],
            'resource_master' => [
                'unlocked' => $resourcesCompleted >= 50,
                'title' => 'Resource Master',
                'description' => 'Complete 50 resources',
                'icon' => '📖',
                'progress' => $resourcesCompleted,
                'total' => 50,
            ],
            'consistent' => [
                'unlocked' => $streak >= 7,
                'title' => 'Consistent',
                'description' => 'Maintain a 7-day streak',
                'icon' => '🔥',
                'progress' => $streak,
                'total' => 7,
            ],
            'unstoppable' => [
                'unlocked' => $streak >= 30,
                'title' => 'Unstoppable',
                'description' => 'Maintain a 30-day streak',
                'icon' => '💪',
                'progress' => $streak,
                'total' => 30,
            ],
        ];
    }

    /**
     * Calculate user level and XP
     */
    public function calculateLevel(User $user): array
    {
        $xp = $this->calculateTotalXP($user);
        $level = floor($xp / 1000) + 1;
        $currentLevelXP = ($level - 1) * 1000;
        $nextLevelXP = $level * 1000;
        $progressXP = $xp - $currentLevelXP;
        $neededXP = $nextLevelXP - $currentLevelXP;

        return [
            'level' => $level,
            'xp' => $xp,
            'progress_xp' => $progressXP,
            'needed_xp' => $neededXP,
            'percentage' => round(($progressXP / $neededXP) * 100, 1),
            'badge' => $this->getLevelBadge($level),
        ];
    }

    /**
     * Calculate total XP
     */
    public function calculateTotalXP(User $user): int
    {
        $xp = 0;

        // Roadmap created: 50 XP
        $xp += $user->roadmaps()->count() * 50;

        // Topic completed: 100 XP
        $xp += $user->topicProgress()->whereNotNull('completed_at')->count() * 100;

        // Resource completed: 25 XP
        $xp += $user->resources()->where('is_completed', true)->count() * 25;

        // Certificate earned: 500 XP
        $xp += $user->certificates()->count() * 500;

        // Time spent: 1 XP per minute
        $xp += $user->topicProgress()->sum('time_spent');

        // Streak bonus: 10 XP per day
        $xp += $this->calculateStreak($user) * 10;

        return $xp;
    }

    /**
     * Get leaderboard
     */
    public function getLeaderboard(int $limit = 10): Collection
    {
        $users = User::with(['roadmaps', 'certificates', 'topicProgress'])
            ->get()
            ->map(function ($user) {
                return [
                    'user' => $user,
                    'xp' => $this->calculateTotalXP($user),
                    'level' => $this->calculateLevel($user)['level'],
                    'streak' => $this->calculateStreak($user),
                    'certificates' => $user->certificates()->count(),
                ];
            })
            ->sortByDesc('xp')
            ->take($limit)
            ->values();

        return $users;
    }

    /**
     * Check if completed roadmap in 30 days
     */
    private function hasCompletedRoadmapIn30Days(User $user): bool
    {
        return $user->roadmaps()
            ->whereNotNull('actual_end_date')
            ->get()
            ->filter(function ($roadmap) {
                if (!$roadmap->start_date || !$roadmap->actual_end_date) {
                    return false;
                }
                $duration = $roadmap->start_date->diffInDays($roadmap->actual_end_date);
                return $duration <= 30;
            })
            ->isNotEmpty();
    }

    /**
     * Get level badge
     */
    public function getLevelBadge(int $level): array
    {
        $badges = [
            ['min' => 1, 'max' => 5, 'name' => 'Beginner', 'color' => 'gray', 'icon' => '🌱'],
            ['min' => 6, 'max' => 10, 'name' => 'Novice', 'color' => 'green', 'icon' => '🌿'],
            ['min' => 11, 'max' => 20, 'name' => 'Learner', 'color' => 'blue', 'icon' => '📘'],
            ['min' => 21, 'max' => 35, 'name' => 'Scholar', 'color' => 'indigo', 'icon' => '🎓'],
            ['min' => 36, 'max' => 50, 'name' => 'Expert', 'color' => 'purple', 'icon' => '💎'],
            ['min' => 51, 'max' => 99, 'name' => 'Master', 'color' => 'yellow', 'icon' => '⭐'],
            ['min' => 100, 'max' => PHP_INT_MAX, 'name' => 'Legend', 'color' => 'orange', 'icon' => '👑'],
        ];

        foreach ($badges as $badge) {
            if ($level >= $badge['min'] && $level <= $badge['max']) {
                return $badge;
            }
        }

        return $badges[0];
    }
}
