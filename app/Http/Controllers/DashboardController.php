<?php

namespace App\Http\Controllers;

use App\Services\GamificationService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected GamificationService $gamificationService
    ) {}

    public function index(Request $request)
    {
        $user = $request->user();

        // Optimized stats
        $stats = [
            'total_roadmaps' => $user->roadmaps()->count(),
            'active_roadmaps' => $user->roadmaps()->where('status', 'in_progress')->count(),
            'completed_roadmaps' => $user->roadmaps()->where('status', 'completed')->count(),
            'certificates_earned' => $user->certificates()->count(),
            'time_spent_hours' => round($user->topicProgress()->sum('time_spent') / 60, 1),
        ];

        // Recent data with eager loading
        $recentRoadmaps = $user->roadmaps()
            ->with(['topics', 'certificate'])
            ->latest()
            ->take(5)
            ->get();

        $recentActivities = $user->activityLogs()
            ->with('loggable')
            ->latest()
            ->take(10)
            ->get();

        // Gamification data
        $gamification = [
            'streak' => $this->gamificationService->calculateStreak($user),
            'achievements' => $this->gamificationService->getAchievements($user),
            'level' => $this->gamificationService->calculateLevel($user),
        ];

        // Chart data
        $chartData = [
            'progressTimeline' => $this->getProgressTimeline($user),
            'activityHeatmap' => $this->getActivityHeatmap($user),
            'timeDistribution' => $this->getTimeDistribution($user),
            'completionFunnel' => $this->getCompletionFunnel($user),
        ];

        return view('dashboard', compact(
            'stats',
            'recentRoadmaps',
            'recentActivities',
            'gamification',
            'chartData'
        ));
    }

    private function getProgressTimeline($user)
    {
        return $user->activityLogs()
            ->where('action', 'topic_completed')
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();
    }

    private function getActivityHeatmap($user)
    {
        return $user->activityLogs()
            ->where('created_at', '>=', now()->subYear())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();
    }

    private function getTimeDistribution($user)
    {
        return $user->roadmaps()
            ->with('topics.progress')
            ->get()
            ->mapWithKeys(function ($roadmap) use ($user) {
                $time = $roadmap->topics->sum(function ($topic) use ($user) {
                    return $user->topicProgress()
                        ->where('topic_id', $topic->id)
                        ->sum('time_spent') ?? 0;
                });
                return [$roadmap->title => round($time / 60, 1)];
            })
            ->filter(fn($time) => $time > 0)
            ->toArray();
    }

    private function getCompletionFunnel($user)
    {
        $total = $user->roadmaps()->withCount('topics')->get()->sum('topics_count');
        $started = $user->topicProgress()->whereNotNull('started_at')->count();
        $completed = $user->topicProgress()->whereNotNull('completed_at')->count();

        return [
            'labels' => ['Total Topics', 'Started', 'Completed'],
            'data' => [$total, $started, $completed],
        ];
    }
}
