<?php

namespace App\Services;

use App\Models\FocusSession;
use App\Models\User;
use App\Models\Topic;
use App\Models\Resource;
use Carbon\Carbon;

class FocusSessionService
{
    protected ChallengeService $challengeService;
    protected WeeklyGoalService $weeklyGoalService;

    public function __construct(ChallengeService $challengeService, WeeklyGoalService $weeklyGoalService)
    {
        $this->challengeService = $challengeService;
        $this->weeklyGoalService = $weeklyGoalService;
    }

    /**
     * Start a new focus session
     */
    public function startSession(
        User $user,
        string $type = 'pomodoro',
        ?Topic $topic = null,
        ?Resource $resource = null,
        ?int $duration = null
    ): FocusSession {
        // End any active session first
        $this->endActiveSession($user, true);

        $config = FocusSession::TYPES[$type];
        $plannedDuration = $duration ?? $config['duration'] ?? $user->getPreference('pomodoro_duration', 25);

        return FocusSession::create([
            'user_id' => $user->id,
            'topic_id' => $topic?->id,
            'resource_id' => $resource?->id,
            'started_at' => now(),
            'planned_duration' => $plannedDuration,
            'type' => $type,
        ]);
    }

    /**
     * End a focus session
     */
    public function endSession(FocusSession $session, bool $interrupted = false): void
    {
        $session->end($interrupted);

        // Update challenges and goals
        if (!$interrupted) {
            $this->challengeService->updateProgress(
                $session->user,
                'time_logged',
                ['minutes' => $session->duration_minutes]
            );

            $this->weeklyGoalService->updateProgress(
                $session->user,
                'focus_session_completed'
            );

            // Update study hours goal (convert to hours)
            if ($session->duration_minutes >= 60) {
                $this->weeklyGoalService->updateProgress(
                    $session->user,
                    'time_logged',
                    intval($session->duration_minutes / 60)
                );
            }
        }
    }

    /**
     * End any active session for a user
     */
    public function endActiveSession(User $user, bool $interrupted = false): ?FocusSession
    {
        $activeSession = $this->getActiveSession($user);
        
        if ($activeSession) {
            $this->endSession($activeSession, $interrupted);
        }

        return $activeSession;
    }

    /**
     * Get user's active session
     */
    public function getActiveSession(User $user): ?FocusSession
    {
        return FocusSession::where('user_id', $user->id)
            ->active()
            ->first();
    }

    /**
     * Get session statistics for a user
     */
    public function getSessionStats(User $user, ?Carbon $from = null, ?Carbon $to = null): array
    {
        $query = FocusSession::where('user_id', $user->id)->completed();

        if ($from) {
            $query->where('started_at', '>=', $from);
        }
        if ($to) {
            $query->where('started_at', '<=', $to);
        }

        $sessions = $query->get();

        return [
            'total_sessions' => $sessions->count(),
            'total_minutes' => $sessions->sum('duration_minutes'),
            'total_hours' => round($sessions->sum('duration_minutes') / 60, 1),
            'completed_sessions' => $sessions->where('was_interrupted', false)->count(),
            'interrupted_sessions' => $sessions->where('was_interrupted', true)->count(),
            'completion_rate' => $sessions->count() > 0 
                ? round(($sessions->where('was_interrupted', false)->count() / $sessions->count()) * 100) 
                : 0,
            'avg_session_length' => $sessions->count() > 0 
                ? round($sessions->avg('duration_minutes')) 
                : 0,
            'sessions_by_type' => $sessions->groupBy('type')->map->count(),
        ];
    }

    /**
     * Get today's focus time in minutes
     */
    public function getTodaysFocusTime(User $user): int
    {
        return FocusSession::where('user_id', $user->id)
            ->completed()
            ->whereDate('started_at', Carbon::today())
            ->sum('duration_minutes');
    }

    /**
     * Get this week's focus time in minutes
     */
    public function getWeeklyFocusTime(User $user): int
    {
        return FocusSession::where('user_id', $user->id)
            ->completed()
            ->whereBetween('started_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('duration_minutes');
    }

    /**
     * Get focus time heatmap data
     */
    public function getFocusHeatmapData(User $user, int $days = 365): array
    {
        $sessions = FocusSession::where('user_id', $user->id)
            ->completed()
            ->where('started_at', '>=', Carbon::now()->subDays($days))
            ->get()
            ->groupBy(fn ($session) => $session->started_at->format('Y-m-d'));

        $data = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $data[$date] = $sessions->get($date)?->sum('duration_minutes') ?? 0;
        }

        return $data;
    }
}
