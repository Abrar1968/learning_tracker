<?php

namespace App\Services;

use App\Models\DailyChallenge;
use App\Models\User;
use Carbon\Carbon;

class ChallengeService
{
    /**
     * Generate daily challenges for a user
     */
    public function generateDailyChallenges(User $user): array
    {
        $today = Carbon::today();
        $challenges = [];

        // Check if challenges already exist for today
        $existingCount = DailyChallenge::where('user_id', $user->id)
            ->where('challenge_date', $today)
            ->count();

        if ($existingCount >= 3) {
            return DailyChallenge::where('user_id', $user->id)
                ->where('challenge_date', $today)
                ->get()
                ->toArray();
        }

        // Generate 3 varied challenges
        $challengeTypes = $this->selectChallengeTypes($user);

        foreach ($challengeTypes as $type) {
            $challenges[] = $this->createChallenge($user, $today, $type);
        }

        return $challenges;
    }

    /**
     * Select appropriate challenge types based on user activity
     */
    protected function selectChallengeTypes(User $user): array
    {
        $types = ['complete_resources', 'study_time', 'complete_topic', 'start_new', 'review', 'streak_bonus'];
        
        // Weight types based on user's current state
        $weighted = [];
        
        // Always include a resource challenge
        $weighted[] = 'complete_resources';
        
        // Add study time challenge
        $weighted[] = 'study_time';
        
        // Add streak bonus if user has an active streak
        if ($user->current_streak > 0) {
            $weighted[] = 'streak_bonus';
        } else {
            // Otherwise encourage starting something new
            $weighted[] = 'start_new';
        }

        return array_slice($weighted, 0, 3);
    }

    /**
     * Create a single challenge
     */
    protected function createChallenge(User $user, Carbon $date, string $type): DailyChallenge
    {
        $config = DailyChallenge::TYPES[$type];
        $requirements = $this->getRequirementsForType($type, $user);

        return DailyChallenge::create([
            'user_id' => $user->id,
            'challenge_date' => $date,
            'type' => $type,
            'title' => $config['title'],
            'description' => str_replace('{count}', $requirements['count'] ?? 1, $config['description']),
            'requirements' => $requirements,
            'progress' => [],
            'xp_reward' => $this->calculateXpReward($type, $requirements),
        ]);
    }

    /**
     * Get requirements based on challenge type and user level
     */
    protected function getRequirementsForType(string $type, User $user): array
    {
        $levelMultiplier = 1 + ($user->level * 0.1);

        return match ($type) {
            'complete_resources' => ['count' => max(2, min(5, intval(2 * $levelMultiplier)))],
            'study_time' => ['count' => max(15, min(60, intval(20 * $levelMultiplier)))],
            'complete_topic' => ['count' => 1],
            'start_new' => ['count' => 1],
            'review' => ['count' => max(3, min(10, intval(3 * $levelMultiplier)))],
            'streak_bonus' => ['count' => 1],
            default => ['count' => 1],
        };
    }

    /**
     * Calculate XP reward based on challenge difficulty
     */
    protected function calculateXpReward(string $type, array $requirements): int
    {
        $baseXp = match ($type) {
            'complete_resources' => 30,
            'study_time' => 40,
            'complete_topic' => 75,
            'start_new' => 25,
            'review' => 35,
            'streak_bonus' => 50,
            default => 25,
        };

        return intval($baseXp * ($requirements['count'] ?? 1) * 0.8);
    }

    /**
     * Update challenge progress
     */
    public function updateProgress(User $user, string $eventType, array $data = []): void
    {
        $today = Carbon::today();
        
        $challenges = DailyChallenge::where('user_id', $user->id)
            ->where('challenge_date', $today)
            ->where('is_completed', false)
            ->get();

        foreach ($challenges as $challenge) {
            $this->processEvent($challenge, $eventType, $data);
        }
    }

    /**
     * Process an event and update challenge progress
     */
    protected function processEvent(DailyChallenge $challenge, string $eventType, array $data): void
    {
        $progress = $challenge->progress ?? [];

        switch ($challenge->type) {
            case 'complete_resources':
                if ($eventType === 'resource_completed') {
                    $progress['count'] = ($progress['count'] ?? 0) + 1;
                }
                break;

            case 'study_time':
                if ($eventType === 'time_logged') {
                    $progress['minutes'] = ($progress['minutes'] ?? 0) + ($data['minutes'] ?? 0);
                }
                break;

            case 'complete_topic':
                if ($eventType === 'topic_completed') {
                    $progress['completed'] = true;
                }
                break;

            case 'start_new':
                if (in_array($eventType, ['topic_started', 'resource_added', 'roadmap_created'])) {
                    $progress['started'] = true;
                }
                break;

            case 'review':
                if ($eventType === 'review_completed') {
                    $progress['count'] = ($progress['count'] ?? 0) + 1;
                }
                break;

            case 'streak_bonus':
                if ($eventType === 'daily_activity') {
                    $progress['maintained'] = true;
                }
                break;
        }

        $challenge->update(['progress' => $progress]);

        // Check if challenge is now complete
        if ($challenge->checkCompletion()) {
            $challenge->markCompleted();
        }
    }

    /**
     * Get today's challenges for a user
     */
    public function getTodaysChallenges(User $user): \Illuminate\Database\Eloquent\Collection
    {
        return DailyChallenge::where('user_id', $user->id)
            ->where('challenge_date', Carbon::today())
            ->get();
    }
}
