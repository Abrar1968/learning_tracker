<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'topic_id',
        'resource_id',
        'next_review_date',
        'last_review_date',
        'interval_days',
        'easiness_factor',
        'repetition_count',
        'quality_score',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'next_review_date' => 'date',
            'last_review_date' => 'date',
            'easiness_factor' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * SM-2 Algorithm constants
     */
    private const MIN_EASINESS_FACTOR = 1.3;

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
     * Scope for items due for review
     */
    public function scopeDueForReview($query)
    {
        return $query->where('is_active', true)
            ->where('next_review_date', '<=', now()->toDateString());
    }

    /**
     * Scope for upcoming reviews
     */
    public function scopeUpcoming($query, int $days = 7)
    {
        return $query->where('is_active', true)
            ->whereBetween('next_review_date', [now()->toDateString(), now()->addDays($days)->toDateString()]);
    }

    /**
     * Record a review using SM-2 algorithm
     * 
     * @param int $quality Score from 0-5 (0-2: fail, 3-5: pass)
     */
    public function recordReview(int $quality): void
    {
        $quality = max(0, min(5, $quality)); // Clamp to 0-5

        // Update easiness factor
        $ef = $this->easiness_factor + (0.1 - (5 - $quality) * (0.08 + (5 - $quality) * 0.02));
        $ef = max(self::MIN_EASINESS_FACTOR, $ef);

        if ($quality < 3) {
            // Failed review - reset
            $this->update([
                'repetition_count' => 0,
                'interval_days' => 1,
                'easiness_factor' => $ef,
                'quality_score' => $quality,
                'last_review_date' => now()->toDateString(),
                'next_review_date' => now()->addDay()->toDateString(),
            ]);
        } else {
            // Successful review
            $repetition = $this->repetition_count + 1;
            
            $interval = match ($repetition) {
                1 => 1,
                2 => 6,
                default => round($this->interval_days * $ef),
            };

            $this->update([
                'repetition_count' => $repetition,
                'interval_days' => $interval,
                'easiness_factor' => $ef,
                'quality_score' => $quality,
                'last_review_date' => now()->toDateString(),
                'next_review_date' => now()->addDays($interval)->toDateString(),
            ]);
        }

        // Award XP for review
        $xp = match (true) {
            $quality >= 4 => 15,
            $quality >= 3 => 10,
            default => 5,
        };
        $this->user->increment('xp', $xp);
    }

    /**
     * Get the reviewable item (topic or resource)
     */
    public function getReviewableAttribute(): Topic|Resource|null
    {
        return $this->topic ?? $this->resource;
    }

    /**
     * Check if due for review today
     */
    public function isDueToday(): bool
    {
        return $this->is_active && $this->next_review_date->isToday();
    }

    /**
     * Check if overdue
     */
    public function isOverdue(): bool
    {
        return $this->is_active && $this->next_review_date->isPast();
    }
}
