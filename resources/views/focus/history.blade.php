<x-layouts.app-with-sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Focus History</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Review your past sessions</p>
                </div>
            </div>
            <a href="{{ route('focus.index') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl font-semibold text-sm text-white shadow-lg hover:shadow-xl transition-all">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Start Session
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white dark:bg-dark-800 rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Sessions</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_sessions'] }}</p>
                </div>
                <div class="bg-white dark:bg-dark-800 rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Hours</p>
                    <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $stats['total_hours'] }}</p>
                </div>
                <div class="bg-white dark:bg-dark-800 rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Avg Session</p>
                    <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['avg_session_length'] }}m</p>
                </div>
                <div class="bg-white dark:bg-dark-800 rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Completion Rate</p>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $stats['completion_rate'] }}%</p>
                </div>
            </div>

            <!-- Session History -->
            <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-dark-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Sessions</h3>
                </div>

                @if($sessions->isEmpty())
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-dark-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No sessions yet</h4>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Start a focus session to begin tracking your progress.</p>
                        <a href="{{ route('focus.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg font-semibold text-sm hover:bg-indigo-700 transition-colors">
                            Start Your First Session
                        </a>
                    </div>
                @else
                    <div class="divide-y divide-gray-200 dark:divide-dark-700">
                        @foreach($sessions as $session)
                            <div class="p-4 hover:bg-gray-50 dark:hover:bg-dark-700/50 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $session->was_interrupted ? 'bg-orange-100 dark:bg-orange-900/30' : 'bg-green-100 dark:bg-green-900/30' }}">
                                            @if($session->was_interrupted)
                                                <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            @else
                                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white">
                                                {{ ucfirst(str_replace('_', ' ', $session->type)) }} Session
                                            </p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $session->started_at->format('M j, Y \a\t g:i A') }}
                                            </p>
                                            @if($session->topic)
                                                <p class="text-xs text-indigo-600 dark:text-indigo-400">
                                                    Topic: {{ $session->topic->title }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold {{ $session->was_interrupted ? 'text-orange-600 dark:text-orange-400' : 'text-green-600 dark:text-green-400' }}">
                                            {{ $session->duration_minutes }} min
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $session->was_interrupted ? 'Interrupted' : 'Completed' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="px-6 py-4 border-t border-gray-200 dark:border-dark-700">
                        {{ $sessions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app-with-sidebar>
