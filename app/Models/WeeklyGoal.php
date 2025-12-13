<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeeklyGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'week_start',
        'type',
        'title',
        'target_value',
        'current_value',
        'xp_reward',
        'is_completed',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'week_start' => 'date',
            'is_completed' => 'boolean',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Goal types
     */
    public const TYPES = [
        'study_hours' => [
            'title' => 'Weekly Study Hours',
            'description' => 'Study for {target} hours this week',
            'icon' => '⏰',
            'default_target' => 10,
        ],
        'resources_completed' => [
            'title' => 'Resource Completionist',
            'description' => 'Complete {target} resources this week',
            'icon' => '📖',
            'default_target' => 15,
        ],
        'topics_completed' => [
            'title' => 'Topic Master',
            'description' => 'Complete {target} topics this week',
            'icon' => '🎯',
            'default_target' => 3,
        ],
        'streak_days' => [
            'title' => 'Consistency King',
            'description' => 'Maintain a {target}-day streak',
            'icon' => '🔥',
            'default_target' => 7,
        ],
        'focus_sessions' => [
            'title' => 'Focus Champion',
            'description' => 'Complete {target} focus sessions',
            'icon' => '🧘',
            'default_target' => 10,
        ],
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get completion percentage
     */
    public function getProgressPercentageAttribute(): int
    {
        if ($this->target_value === 0) {
            return 0;
        }
        return min(100, intval(($this->current_value / $this->target_value) * 100));
    }

    /**
     * Check if goal is completed
     */
    public function checkCompletion(): bool
    {
        return $this->current_value >= $this->target_value;
    }

    /**
     * Increment progress and check for completion
     */
    public function incrementProgress(int $amount = 1): void
    {
        $this->increment('current_value', $amount);

        if ($this->checkCompletion() && !$this->is_completed) {
            $this->markCompleted();
        }
    }

    /**
     * Mark goal as completed
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
     * Get the week end date
     */
    public function getWeekEndAttribute(): \Carbon\Carbon
    {
        return $this->week_start->copy()->addDays(6);
    }
}
