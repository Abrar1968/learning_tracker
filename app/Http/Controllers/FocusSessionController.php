<?php

namespace App\Http\Controllers;

use App\Models\FocusSession;
use App\Services\FocusSessionService;
use Illuminate\Http\Request;

class FocusSessionController extends Controller
{
    public function __construct(
        protected FocusSessionService $focusService
    ) {}

    /**
     * Display focus timer page
     */
    public function index()
    {
        $user = auth()->user();
        $activeSession = $this->focusService->getActiveSession($user);
        $todayStats = [
            'focus_time' => $this->focusService->getTodaysFocusTime($user),
            'weekly_time' => $this->focusService->getWeeklyFocusTime($user),
        ];
        $stats = $this->focusService->getSessionStats($user);

        return view('focus.index', compact('activeSession', 'todayStats', 'stats'));
    }

    /**
     * Start a new focus session
     */
    public function start(Request $request)
    {
        $validated = $request->validate([
            'type' => 'sometimes|in:pomodoro,deep_work,custom',
            'topic_id' => 'nullable|exists:topics,id',
            'resource_id' => 'nullable|exists:resources,id',
            'duration' => 'sometimes|integer|min:1|max:180',
        ]);

        $user = auth()->user();
        $topic = !empty($validated['topic_id'])
            ? \App\Models\Topic::find($validated['topic_id'])
            : null;
        $resource = !empty($validated['resource_id'])
            ? \App\Models\Resource::find($validated['resource_id'])
            : null;

        $session = $this->focusService->startSession(
            $user,
            $validated['type'] ?? 'pomodoro',
            $topic,
            $resource,
            $validated['duration'] ?? null
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'session' => $session,
            ]);
        }

        return redirect()->back()->with('success', 'Focus session started!');
    }

    /**
     * End current focus session
     */
    public function end(Request $request, FocusSession $session)
    {
        $validated = $request->validate([
            'interrupted' => 'sometimes|boolean',
            'notes' => 'sometimes|string|max:1000',
        ]);

        if ($session->user_id !== auth()->id()) {
            abort(403);
        }

        if ($validated['notes'] ?? null) {
            $session->update(['notes' => $validated['notes']]);
        }

        $this->focusService->endSession($session, $validated['interrupted'] ?? false);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'session' => $session->fresh(),
            ]);
        }

        return redirect()->back()->with('success', 'Focus session completed!');
    }

    /**
     * Get current session status (for polling/websocket)
     */
    public function status()
    {
        $session = $this->focusService->getActiveSession(auth()->user());

        return response()->json([
            'active' => $session !== null,
            'session' => $session,
            'elapsed_minutes' => $session?->elapsed_minutes,
            'remaining_minutes' => $session?->remaining_minutes,
        ]);
    }

    /**
     * Get session history
     */
    public function history(Request $request)
    {
        $user = auth()->user();

        $sessions = FocusSession::where('user_id', $user->id)
            ->completed()
            ->with(['topic', 'resource'])
            ->orderByDesc('started_at')
            ->paginate(20);

        $stats = $this->focusService->getSessionStats($user);

        return view('focus.history', compact('sessions', 'stats'));
    }

    /**
     * Get heatmap data
     */
    public function heatmap()
    {
        $data = $this->focusService->getFocusHeatmapData(auth()->user());

        return response()->json($data);
    }
}
