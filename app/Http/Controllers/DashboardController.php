<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Calculate statistics
        $stats = [
            'total_roadmaps' => $user->roadmaps()->count(),
            'active_roadmaps' => $user->roadmaps()->where('status', 'in_progress')->count(),
            'completed_roadmaps' => $user->roadmaps()->where('status', 'completed')->count(),
            'certificates_earned' => $user->certificates()->count(),
            'time_spent_hours' => $user->topicProgress()
                ->sum(DB::raw('COALESCE(time_spent_minutes, 0)')) / 60,
        ];

        // Format time spent to show as integer
        $stats['time_spent_hours'] = (int) round($stats['time_spent_hours']);

        // Get recent roadmaps with topic counts and progress
        $recentRoadmaps = $user->roadmaps()
            ->withCount('topics')
            ->latest()
            ->limit(5)
            ->get();

        // Get recent activities
        $recentActivities = $user->activityLogs()
            ->with('loggable')
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard', compact('stats', 'recentRoadmaps', 'recentActivities'));
    }
}
