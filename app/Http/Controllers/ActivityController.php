<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of user's activities.
     */
    public function index(Request $request)
    {
        $activities = $request->user()
            ->activityLogs()
            ->with('loggable')
            ->latest('created_at')
            ->paginate(20);

        return view('activities.index', compact('activities'));
    }
}
