<x-layouts.app-with-sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Focus Timer</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Stay focused and productive</p>
                </div>
            </div>
            <a href="{{ route('focus.history') }}"
               class="inline-flex items-center px-4 py-2 bg-white dark:bg-dark-700 border border-gray-200 dark:border-dark-600 rounded-xl font-semibold text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-dark-600 transition-all shadow-sm hover:shadow">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                View History
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Main Timer -->
        <div class="xl:col-span-2">
            <x-pomodoro-timer :session="$activeSession" />
        </div>

        <!-- Sidebar Stats -->
        <div class="space-y-6">
            <!-- Today's Progress Card -->
            <div class="bg-white dark:bg-dark-800 rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                    <h3 class="text-lg font-bold text-white">Today's Progress</h3>
                </div>
                <div class="p-6 space-y-5">
                    <!-- Focus Time Progress -->
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600 dark:text-gray-400 font-medium">Focus Time</span>
                            <span class="font-bold text-gray-900 dark:text-white">
                                {{ floor($todayStats['focus_time'] / 60) }}h {{ $todayStats['focus_time'] % 60 }}m
                            </span>
                        </div>
                        <div class="relative w-full bg-gray-200 dark:bg-dark-700 rounded-full h-3 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full transition-all duration-500"
                                 style="width: {{ min(100, ($todayStats['focus_time'] / 240) * 100) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">Goal: 4 hours daily</p>
                    </div>

                    <!-- Sessions Counter -->
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl border border-green-100 dark:border-green-800/30">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-green-500/30">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">Sessions Completed</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Today</p>
                            </div>
                        </div>
                        <span class="text-3xl font-black text-green-600 dark:text-green-400">{{ $stats['total_sessions'] ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <!-- Weekly Overview -->
            <div class="bg-white dark:bg-dark-800 rounded-2xl shadow-xl p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">This Week</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-4 bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-xl border border-indigo-100 dark:border-indigo-800/30">
                        <p class="text-3xl font-black bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            {{ round($todayStats['weekly_time'] / 60, 1) }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Hours Focused</p>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl border border-purple-100 dark:border-purple-800/30">
                        <p class="text-3xl font-black bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                            {{ $stats['completion_rate'] ?? 0 }}%
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Completion Rate</p>
                    </div>
                </div>
            </div>

            <!-- Focus Tips -->
            <div class="bg-gradient-to-br from-orange-500 via-red-500 to-pink-500 rounded-2xl shadow-xl p-6 text-white relative overflow-hidden">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>

                <div class="relative">
                    <h3 class="text-lg font-bold mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                        Pro Tips
                    </h3>
                    <ul class="space-y-3 text-white/90">
                        <li class="flex items-start">
                            <span class="w-5 h-5 bg-white/20 rounded-full flex items-center justify-center text-xs font-bold mr-2 mt-0.5 flex-shrink-0">1</span>
                            <span class="text-sm">Take a 5-minute break after each session</span>
                        </li>
                        <li class="flex items-start">
                            <span class="w-5 h-5 bg-white/20 rounded-full flex items-center justify-center text-xs font-bold mr-2 mt-0.5 flex-shrink-0">2</span>
                            <span class="text-sm">After 4 sessions, take a 15-30 min break</span>
                        </li>
                        <li class="flex items-start">
                            <span class="w-5 h-5 bg-white/20 rounded-full flex items-center justify-center text-xs font-bold mr-2 mt-0.5 flex-shrink-0">3</span>
                            <span class="text-sm">Press <kbd class="px-2 py-1 bg-white/20 rounded-lg text-xs font-mono">Space</kbd> to start/pause</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app-with-sidebar>
