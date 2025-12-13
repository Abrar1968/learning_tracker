<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyChallenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'challenge_date',
        'type',
        'title',
        'description',
        'requirements',
        'progress',
        'xp_reward',
        'is_completed',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'challenge_date' => 'date',
            'requirements' => 'array',
            'progress' => 'array',
            'is_completed' => 'boolean',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Challenge types
     */
    public const TYPES = [
        'complete_resources' => [
            'title' => 'Resource Hunter',
            'description' => 'Complete {count} resources today',
            'icon' => '📚',
        ],
        'study_time' => [
            'title' => 'Time Master',
            'description' => 'Study for {count} minutes today',
            'icon' => '⏱️',
        ],
        'complete_topic' => [
            'title' => 'Topic Terminator',
            'description' => 'Complete a topic today',
            'icon' => '🎯',
        ],
        'start_new' => [
            'title' => 'Explorer',
            'description' => 'Start learning something new',
            'icon' => '🚀',
        ],
        'review' => [
            'title' => 'Memory Master',
            'description' => 'Review {count} items from spaced repetition',
            'icon' => '🧠',
        ],
        'streak_bonus' => [
            'title' => 'Streak Champion',
            'description' => 'Maintain your streak',
            'icon' => '🔥',
        ],
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the challenge requirements are met
     */
    public function checkCompletion(): bool
    {
        $progress = $this->progress ?? [];
        $requirements = $this->requirements;

        switch ($this->type) {
            case 'complete_resources':
                return ($progress['count'] ?? 0) >= $requirements['count'];
            case 'study_time':
                return ($progress['minutes'] ?? 0) >= $requirements['count'];
            case 'complete_topic':
                return ($progress['completed'] ?? false) === true;
            case 'start_new':
                return ($progress['started'] ?? false) === true;
            case 'review':
                return ($progress['count'] ?? 0) >= $requirements['count'];
            case 'streak_bonus':
                return ($progress['maintained'] ?? false) === true;
            default:
                return false;
        }
    }

    /**
     * Mark challenge as completed
     */
    public function markCompleted(): void
    {
        $this->update([
            'is_completed' => true,
            'completed_at' => now(),
        ]);

        // Award XP to user
        $this->user->increment('xp', $this->xp_reward);
    }

    /**
     * Get completion percentage
     */
    public function getProgressPercentageAttribute(): int
    {
        $progress = $this->progress ?? [];
        $requirements = $this->requirements;

        switch ($this->type) {
            case 'complete_resources':
            case 'review':
                $current = $progress['count'] ?? 0;
                $target = $requirements['count'] ?? 1;
                return min(100, intval(($current / $target) * 100));
            case 'study_time':
                $current = $progress['minutes'] ?? 0;
                $target = $requirements['count'] ?? 1;
                return min(100, intval(($current / $target) * 100));
            case 'complete_topic':
            case 'start_new':
            case 'streak_bonus':
                return $this->is_completed ? 100 : 0;
            default:
                return 0;
        }
    }
}
