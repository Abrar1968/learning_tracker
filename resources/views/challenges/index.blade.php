<x-layouts.app-with-sidebar>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-gradient-to-br from-amber-500 to-yellow-500 rounded-xl shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Challenges & Goals</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Track your daily progress</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Weekly Summary -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-xl p-8 mb-8 text-white">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-bold">Weekly Progress</h3>
                        <p class="text-white/70">{{ now()->startOfWeek()->format('M j') }} - {{ now()->endOfWeek()->format('M j, Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-4xl font-bold">{{ $goalsSummary['completed'] ?? 0 }}/{{ $goalsSummary['total'] ?? 0 }}</p>
                        <p class="text-white/70">Goals Completed</p>
                    </div>
                </div>

                <div class="w-full bg-white/20 rounded-full h-3">
                    <div class="bg-white h-3 rounded-full transition-all duration-500"
                         style="width: {{ ($goalsSummary['total'] ?? 0) > 0 ? (($goalsSummary['completed'] ?? 0) / ($goalsSummary['total'] ?? 0)) * 100 : 0 }}%"></div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                    <div class="bg-white/10 rounded-lg p-4 text-center">
                        <p class="text-2xl font-bold">{{ $goalsSummary['xp_earned'] ?? 0 }}</p>
                        <p class="text-xs text-white/70">XP Earned</p>
                    </div>
                    <div class="bg-white/10 rounded-lg p-4 text-center">
                        <p class="text-2xl font-bold">{{ $goalsSummary['streak'] ?? 0 }}</p>
                        <p class="text-xs text-white/70">Day Streak</p>
                    </div>
                    <div class="bg-white/10 rounded-lg p-4 text-center">
                        <p class="text-2xl font-bold">{{ $goalsSummary['challenges_completed'] ?? 0 }}</p>
                        <p class="text-xs text-white/70">Challenges Done</p>
                    </div>
                    <div class="bg-white/10 rounded-lg p-4 text-center">
                        <p class="text-2xl font-bold">{{ $goalsSummary['focus_hours'] ?? 0 }}</p>
                        <p class="text-xs text-white/70">Focus Hours</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Daily Challenges -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"/>
                            </svg>
                            Today's Challenges
                        </h3>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ now()->format('l, M j') }}
                        </span>
                    </div>

                    @if($dailyChallenges->isEmpty())
                        <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-8 text-center">
                            <div class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No challenges today</h4>
                            <p class="text-gray-500 dark:text-gray-400">Check back tomorrow for new challenges!</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($dailyChallenges as $challenge)
                                <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-5 {{ $challenge->is_completed ? 'ring-2 ring-green-500' : '' }}">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-4">
                                            <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0 {{ $challenge->is_completed ? 'bg-green-100 dark:bg-green-900/30' : 'bg-yellow-100 dark:bg-yellow-900/30' }}">
                                                @if($challenge->is_completed)
                                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                @else
                                                    @switch($challenge->type)
                                                        @case('complete_topics')
                                                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            @break
                                                        @case('study_time')
                                                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            @break
                                                        @case('complete_resources')
                                                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                            </svg>
                                                            @break
                                                        @default
                                                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                            </svg>
                                                    @endswitch
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900 dark:text-white {{ $challenge->is_completed ? 'line-through text-gray-500' : '' }}">
                                                    {{ $challenge->title }}
                                                </h4>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ $challenge->description ?? '' }}
                                                </p>

                                                @if(!$challenge->is_completed)
                                                    <div class="mt-3">
                                                        <div class="flex justify-between text-xs mb-1">
                                                            <span class="text-gray-500 dark:text-gray-400">Progress</span>
                                                            <span class="text-indigo-600 dark:text-indigo-400 font-semibold">{{ $challenge->progress_percentage }}%</span>
                                                        </div>
                                                        <div class="w-full bg-gray-200 dark:bg-dark-700 rounded-full h-2">
                                                            <div class="bg-indigo-600 h-2 rounded-full transition-all" style="width: {{ $challenge->progress_percentage }}%"></div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $challenge->is_completed ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' }}">
                                                +{{ $challenge->xp_reward }} XP
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Weekly Goals -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Weekly Goals
                        </h3>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ now()->diff(now()->endOfWeek())->days }} days left
                        </span>
                    </div>

                    @if($weeklyGoals->isEmpty())
                        <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-8 text-center">
                            <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No weekly goals set</h4>
                            <p class="text-gray-500 dark:text-gray-400">Goals will be generated at the start of each week.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($weeklyGoals as $goal)
                                <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-5 {{ $goal->is_completed ? 'ring-2 ring-green-500' : '' }}">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $goal->is_completed ? 'bg-green-100 dark:bg-green-900/30' : 'bg-purple-100 dark:bg-purple-900/30' }} mr-3">
                                                @if($goal->is_completed)
                                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 dark:text-white {{ $goal->is_completed ? 'line-through text-gray-500' : '' }}">
                                                    {{ \App\Models\WeeklyGoal::TYPES[$goal->type]['name'] ?? ucfirst(str_replace('_', ' ', $goal->type)) }}
                                                </h4>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $goal->current_value }}/{{ $goal->target_value }} {{ \App\Models\WeeklyGoal::TYPES[$goal->type]['unit'] ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $goal->is_completed ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' }}">
                                            +{{ $goal->xp_reward }} XP
                                        </span>
                                    </div>

                                    <div class="w-full bg-gray-200 dark:bg-dark-700 rounded-full h-3">
                                        <div class="h-3 rounded-full transition-all {{ $goal->is_completed ? 'bg-green-500' : 'bg-purple-600' }}"
                                             style="width: {{ min(100, $goal->progress_percentage) }}%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 text-right">
                                        {{ $goal->progress_percentage }}% complete
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Motivation Section -->
            <div class="mt-12 bg-white dark:bg-dark-800 rounded-xl shadow-lg p-8">
                <div class="text-center max-w-2xl mx-auto">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Keep Going! 🚀</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Consistency is the key to mastery. Complete your daily challenges to build momentum and earn bonus XP!
                    </p>
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('focus.index') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Start Focus Session
                        </a>
                        <a href="{{ route('roadmaps.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 dark:bg-dark-700 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-200 dark:hover:bg-dark-600 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            View Roadmaps
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app-with-sidebar>
