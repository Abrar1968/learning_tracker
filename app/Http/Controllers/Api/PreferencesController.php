<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PreferencesController extends Controller
{
    /**
     * Update user preferences
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'sometimes|in:light,dark,system',
            'keyboard_shortcuts' => 'sometimes|boolean',
            'email_notifications' => 'sometimes|boolean',
            'weekly_digest' => 'sometimes|boolean',
            'pomodoro_duration' => 'sometimes|integer|min:1|max:120',
            'short_break_duration' => 'sometimes|integer|min:1|max:30',
            'long_break_duration' => 'sometimes|integer|min:1|max:60',
            'daily_goal_hours' => 'sometimes|integer|min:1|max:24',
            'sound_enabled' => 'sometimes|boolean',
        ]);

        $user = auth()->user();
        $preferences = $user->preferences ?? [];

        foreach ($validated as $key => $value) {
            $preferences[$key] = $value;
        }

        $user->update(['preferences' => $preferences]);

        return response()->json([
            'success' => true,
            'preferences' => $preferences,
        ]);
    }

    /**
     * Get user preferences
     */
    public function show()
    {
        $user = auth()->user();
        $defaults = $user::DEFAULT_PREFERENCES;
        $preferences = array_merge($defaults, $user->preferences ?? []);

        return response()->json($preferences);
    }
}
