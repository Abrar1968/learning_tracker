<?php

namespace App\Services;

use App\Models\ReviewSchedule;
use App\Models\User;
use App\Models\Topic;
use App\Models\Resource;
use Carbon\Carbon;

class SpacedRepetitionService
{
    /**
     * Add an item to the spaced repetition queue
     */
    public function addToReviewQueue(
        User $user,
        Topic|Resource $item,
        ?int $initialInterval = 1
    ): ReviewSchedule {
        $type = $item instanceof Topic ? 'topic_id' : 'resource_id';
        
        // Check if already in queue
        $existing = ReviewSchedule::where('user_id', $user->id)
            ->where($type, $item->id)
            ->first();

        if ($existing) {
            // Reactivate if inactive
            if (!$existing->is_active) {
                $existing->update([
                    'is_active' => true,
                    'next_review_date' => Carbon::now()->addDays($initialInterval),
                ]);
            }
            return $existing;
        }

        return ReviewSchedule::create([
            'user_id' => $user->id,
            $type => $item->id,
            'next_review_date' => Carbon::now()->addDays($initialInterval),
            'interval_days' => $initialInterval,
        ]);
    }

    /**
     * Record a review with quality score (0-5)
     */
    public function recordReview(ReviewSchedule $schedule, int $quality): void
    {
        $schedule->recordReview($quality);

        // Update challenge progress
        app(ChallengeService::class)->updateProgress(
            $schedule->user,
            'review_completed'
        );
    }

    /**
     * Get items due for review
     */
    public function getDueReviews(User $user, int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return ReviewSchedule::with(['topic', 'resource'])
            ->where('user_id', $user->id)
            ->dueForReview()
            ->orderBy('next_review_date')
            ->limit($limit)
            ->get();
    }

    /**
     * Get upcoming reviews
     */
    public function getUpcomingReviews(User $user, int $days = 7): \Illuminate\Database\Eloquent\Collection
    {
        return ReviewSchedule::with(['topic', 'resource'])
            ->where('user_id', $user->id)
            ->upcoming($days)
            ->orderBy('next_review_date')
            ->get();
    }

    /**
     * Get review statistics
     */
    public function getReviewStats(User $user): array
    {
        $schedules = ReviewSchedule::where('user_id', $user->id)
            ->where('is_active', true)
            ->get();

        $dueToday = $schedules->filter(fn ($s) => $s->isDueToday())->count();
        $overdue = $schedules->filter(fn ($s) => $s->isOverdue() && !$s->isDueToday())->count();

        return [
            'total_items' => $schedules->count(),
            'due_today' => $dueToday,
            'overdue' => $overdue,
            'upcoming_week' => $schedules->filter(
                fn ($s) => $s->next_review_date->between(now(), now()->addDays(7))
            )->count(),
            'avg_easiness' => round($schedules->avg('easiness_factor'), 2),
            'total_reviews' => $schedules->sum('repetition_count'),
        ];
    }

    /**
     * Get review calendar data
     */
    public function getReviewCalendar(User $user, int $days = 30): array
    {
        $schedules = ReviewSchedule::where('user_id', $user->id)
            ->where('is_active', true)
            ->where('next_review_date', '<=', now()->addDays($days))
            ->get();

        $calendar = [];
        for ($i = 0; $i < $days; $i++) {
            $date = now()->addDays($i)->format('Y-m-d');
            $calendar[$date] = $schedules->filter(
                fn ($s) => $s->next_review_date->format('Y-m-d') === $date
            )->count();
        }

        return $calendar;
    }

    /**
     * Suspend a review item
     */
    public function suspend(ReviewSchedule $schedule): void
    {
        $schedule->update(['is_active' => false]);
    }

    /**
     * Resume a suspended review item
     */
    public function resume(ReviewSchedule $schedule): void
    {
        $schedule->update([
            'is_active' => true,
            'next_review_date' => now()->addDay(),
        ]);
    }

    /**
     * Reset review progress for an item
     */
    public function reset(ReviewSchedule $schedule): void
    {
        $schedule->update([
            'interval_days' => 1,
            'easiness_factor' => 2.5,
            'repetition_count' => 0,
            'next_review_date' => now()->addDay(),
        ]);
    }
}
