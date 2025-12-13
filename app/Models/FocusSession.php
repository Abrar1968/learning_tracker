<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FocusSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'topic_id',
        'resource_id',
        'started_at',
        'ended_at',
        'duration_minutes',
        'planned_duration',
        'type',
        'was_interrupted',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
            'was_interrupted' => 'boolean',
        ];
    }

    /**
     * Session types
     */
    public const TYPES = [
        'pomodoro' => [
            'name' => 'Pomodoro',
            'duration' => 25,
            'short_break' => 5,
            'long_break' => 15,
            'sessions_before_long_break' => 4,
        ],
        'deep_work' => [
            'name' => 'Deep Work',
            'duration' => 90,
            'short_break' => 20,
            'long_break' => 30,
            'sessions_before_long_break' => 2,
        ],
        'custom' => [
            'name' => 'Custom',
            'duration' => null,
            'short_break' => null,
            'long_break' => null,
            'sessions_before_long_break' => null,
        ],
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Scope for active (ongoing) sessions
     */
    public function scopeActive($query)
    {
        return $query->whereNull('ended_at');
    }

    /**
     * Scope for completed sessions
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('ended_at');
    }

    /**
     * End the current session
     */
    public function end(bool $interrupted = false): void
    {
        $this->update([
            'ended_at' => now(),
            'duration_minutes' => $this->started_at->diffInMinutes(now()),
            'was_interrupted' => $interrupted,
        ]);

        // Log time to topic if associated
        if ($this->topic_id) {
            $this->topic->increment('actual_hours', $this->duration_minutes / 60);
        }

        // Award XP if completed without interruption
        if (!$interrupted && $this->duration_minutes >= $this->planned_duration) {
            $xp = match ($this->type) {
                'pomodoro' => 10,
                'deep_work' => 30,
                default => 5,
            };
            $this->user->increment('xp', $xp);
        }
    }

    /**
     * Check if session is currently active
     */
    public function isActive(): bool
    {
        return $this->ended_at === null;
    }

    /**
     * Get elapsed time in minutes
     */
    public function getElapsedMinutesAttribute(): int
    {
        if ($this->ended_at) {
            return $this->duration_minutes;
        }
        return $this->started_at->diffInMinutes(now());
    }

    /**
     * Get remaining time in minutes
     */
    public function getRemainingMinutesAttribute(): int
    {
        return max(0, $this->planned_duration - $this->elapsed_minutes);
    }
}
