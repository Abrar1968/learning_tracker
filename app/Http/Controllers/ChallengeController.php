<?php

namespace App\Http\Controllers;

use App\Models\DailyChallenge;
use App\Models\WeeklyGoal;
use App\Services\ChallengeService;
use App\Services\WeeklyGoalService;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    public function __construct(
        protected ChallengeService $challengeService,
        protected WeeklyGoalService $weeklyGoalService
    ) {}

    /**
     * Display challenges and goals dashboard
     */
    public function index()
    {
        $user = auth()->user();
        
        // Generate daily challenges if needed
        $this->challengeService->generateDailyChallenges($user);
        $dailyChallenges = $this->challengeService->getTodaysChallenges($user);
        
        // Generate weekly goals if needed
        $this->weeklyGoalService->generateWeeklyGoals($user);
        $weeklyGoals = $this->weeklyGoalService->getCurrentWeekGoals($user);
        $goalsSummary = $this->weeklyGoalService->getGoalsSummary($user);

        return view('challenges.index', compact('dailyChallenges', 'weeklyGoals', 'goalsSummary'));
    }

    /**
     * Get challenges for API/AJAX
     */
    public function getChallenges()
    {
        $user = auth()->user();
        $this->challengeService->generateDailyChallenges($user);
        $challenges = $this->challengeService->getTodaysChallenges($user);

        return response()->json([
            'challenges' => $challenges,
            'completed' => $challenges->where('is_completed', true)->count(),
            'total' => $challenges->count(),
        ]);
    }

    /**
     * Get weekly goals for API/AJAX
     */
    public function getGoals()
    {
        $user = auth()->user();
        $this->weeklyGoalService->generateWeeklyGoals($user);
        $goals = $this->weeklyGoalService->getCurrentWeekGoals($user);
        $summary = $this->weeklyGoalService->getGoalsSummary($user);

        return response()->json([
            'goals' => $goals,
            'summary' => $summary,
        ]);
    }

    /**
     * Refresh daily challenges (admin/testing)
     */
    public function refreshChallenges()
    {
        $user = auth()->user();
        
        // Delete today's incomplete challenges
        DailyChallenge::where('user_id', $user->id)
            ->whereDate('challenge_date', today())
            ->where('is_completed', false)
            ->delete();

        // Generate new ones
        $this->challengeService->generateDailyChallenges($user);

        return redirect()->back()->with('success', 'Daily challenges refreshed!');
    }
}
