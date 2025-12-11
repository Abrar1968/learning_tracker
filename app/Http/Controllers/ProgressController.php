<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Services\ProgressService;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function __construct(
        protected ProgressService $progressService
    ) {
        $this->middleware('auth');
    }

    /**
     * Start tracking progress for a topic.
     */
    public function start(Topic $topic, Request $request)
    {
        $progress = $this->progressService->startTopic($topic, $request->user());

        return redirect()
            ->back()
            ->with('success', 'Topic started! Good luck!');
    }

    /**
     * Update progress for a topic.
     */
    public function update(Topic $topic, Request $request)
    {
        $validated = $request->validate([
            'progress_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'quality_score' => ['nullable', 'numeric', 'min:0', 'max:10'],
            'notes' => ['nullable', 'string'],
        ]);

        $progress = $topic->progress()
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $this->progressService->updateProgress($progress, $validated);

        return redirect()
            ->back()
            ->with('success', 'Progress updated successfully!');
    }

    /**
     * Log time spent on a topic.
     */
    public function logTime(Topic $topic, Request $request)
    {
        $validated = $request->validate([
            'minutes' => ['required', 'integer', 'min:1'],
        ]);

        $progress = $topic->progress()
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $this->progressService->logTime($progress, $validated['minutes']);

        return redirect()
            ->back()
            ->with('success', 'Time logged successfully!');
    }

    /**
     * Complete a topic.
     */
    public function complete(Topic $topic, Request $request)
    {
        $progress = $topic->progress()
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $this->progressService->updateProgress($progress, [
            'progress_percentage' => 100,
            'completed_at' => now(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Topic completed! Well done!');
    }
}
