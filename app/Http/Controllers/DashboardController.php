<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_roadmaps' => 0,
            'active_roadmaps' => 0,
            'completed_roadmaps' => 0,
            'total_resources' => 0,
            'resources_completed' => 0,
            'certificates_earned' => 0,
        ];

        return view('dashboard', compact('stats'));
    }
}
