<?php

namespace App\Http\Controllers;

use App\Models\ReviewSchedule;
use App\Services\SpacedRepetitionService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(
        protected SpacedRepetitionService $reviewService
    ) {}

    /**
     * Display spaced repetition review dashboard
     */
    public function index()
    {
        $user = auth()->user();
        
        $dueReviews = $this->reviewService->getDueReviews($user, 20);
        $upcomingReviews = $this->reviewService->getUpcomingReviews($user);
        $stats = $this->reviewService->getReviewStats($user);
        $calendar = $this->reviewService->getReviewCalendar($user);

        return view('reviews.index', compact('dueReviews', 'upcomingReviews', 'stats', 'calendar'));
    }

    /**
     * Show review session for a specific item
     */
    public function show(ReviewSchedule $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $review->load(['topic', 'resource']);

        return view('reviews.show', compact('review'));
    }

    /**
     * Record review result
     */
    public function record(Request $request, ReviewSchedule $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'quality' => 'required|integer|min:0|max:5',
        ]);

        $this->reviewService->recordReview($review, $validated['quality']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'next_review' => $review->fresh()->next_review_date->format('Y-m-d'),
                'interval' => $review->interval_days,
            ]);
        }

        // Get next due review
        $nextReview = $this->reviewService->getDueReviews(auth()->user(), 1)->first();

        if ($nextReview) {
            return redirect()
                ->route('reviews.show', $nextReview)
                ->with('success', 'Review recorded! Next review scheduled for ' . $review->next_review_date->format('M j, Y'));
        }

        return redirect()
            ->route('reviews.index')
            ->with('success', 'All reviews complete for now!');
    }

    /**
     * Add topic to review queue
     */
    public function addTopic(Request $request, \App\Models\Topic $topic)
    {
        $schedule = $this->reviewService->addToReviewQueue(auth()->user(), $topic);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'schedule' => $schedule,
            ]);
        }

        return redirect()->back()->with('success', 'Topic added to spaced repetition queue!');
    }

    /**
     * Add resource to review queue
     */
    public function addResource(Request $request, \App\Models\Resource $resource)
    {
        $schedule = $this->reviewService->addToReviewQueue(auth()->user(), $resource);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'schedule' => $schedule,
            ]);
        }

        return redirect()->back()->with('success', 'Resource added to spaced repetition queue!');
    }

    /**
     * Suspend a review item
     */
    public function suspend(ReviewSchedule $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $this->reviewService->suspend($review);

        return redirect()->back()->with('success', 'Review suspended');
    }

    /**
     * Resume a suspended review item
     */
    public function resume(ReviewSchedule $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $this->reviewService->resume($review);

        return redirect()->back()->with('success', 'Review resumed');
    }

    /**
     * Reset review progress
     */
    public function reset(ReviewSchedule $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $this->reviewService->reset($review);

        return redirect()->back()->with('success', 'Review progress reset');
    }
}
