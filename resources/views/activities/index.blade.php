<x-layouts.app-with-sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-3xl text-gray-900 leading-tight">
                    {{ __('Activity Feed') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">Tracking your learning journey</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-8">
                @if ($activities->isEmpty())
                    <div class="relative bg-white rounded-3xl shadow-2xl border-t-4 border-indigo-500 p-12 text-center overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/30 to-purple-50/30"></div>
                        <div class="relative z-10">
                            <div class="w-20 h-20 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                                <svg class="h-10 w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="mt-2 text-2xl font-black text-slate-900">No activity recorded</h3>
                            <p class="mt-1 text-slate-600">Start your learning journey to see your progress here.</p>
                            <div class="mt-6">
                                <a href="{{ route('roadmaps.index') }}"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all shadow-xl hover:shadow-2xl">
                                    Start Learning
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="relative">
                        <!-- Connecting Line -->
                        <div class="absolute top-0 bottom-0 left-8 w-1 bg-gradient-to-b from-indigo-200 via-purple-200 to-pink-200 rounded-full"></div>

                        <div class="space-y-8 relative">
                            @foreach ($activities as $activity)
                                <div class="relative flex items-start group">
                                    <!-- Timeline Icon -->
                                    <div class="flex items-center justify-center w-16 flex-shrink-0">
                                        <div
                                            class="relative z-10 flex items-center justify-center w-12 h-12 bg-gradient-to-br from-white to-gray-50 rounded-full border-2 border-white shadow-lg ring-2 ring-slate-200 group-hover:ring-indigo-400 group-hover:shadow-xl transition-all duration-300 transform group-hover:scale-110">
                                            @switch($activity->action)
                                                @case('roadmap_created')
                                                @case('roadmap_started')
                                                    <div class="text-indigo-600">
                                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                        </svg>
                                                    </div>
                                                @break

                                                @case('roadmap_completed')
                                                @case('topic_completed')

                                                @case('resource_completed')
                                                    <div class="text-green-600">
                                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </div>
                                                @break

                                                @case('certificate_generated')
                                                    <div class="text-yellow-500">
                                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                @break

                                                @case('time_logged')
                                                    <div class="text-blue-500">
                                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                @break

                                                @default
                                                    <div class="text-slate-500">
                                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                    </div>
                                            @endswitch
                                        </div>
                                    </div>

                                    <!-- Content Card -->
                                    <div class="flex-1 min-w-0 ml-4">
                                        <div
                                            class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 hover:border-indigo-300">
                                            <div class="flex items-center justify-between mb-2">
                                                <h3 class="text-sm font-bold text-slate-900">
                                                    {{ ucfirst(str_replace('_', ' ', $activity->action)) }}
                                                </h3>
                                                <span class="text-xs font-medium text-slate-400">
                                                    {{ $activity->created_at->diffForHumans() }}
                                                </span>
                                            </div>

                                            <div class="text-sm text-slate-600 mb-3">
                                                {{ $activity->description }}
                                            </div>

                                            @if ($activity->loggable)
                                                <div class="flex items-center pt-3 border-t border-slate-50">
                                                    @if ($activity->loggable_type === 'App\\Models\\Roadmap')
                                                        <a href="{{ route('roadmaps.show', $activity->loggable) }}"
                                                            class="inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                                            View Roadmap <svg class="ml-1 w-3 h-3" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M9 5l7 7-7 7" />
                                                            </svg>
                                                        </a>
                                                    @elseif($activity->loggable_type === 'App\\Models\\Topic')
                                                        <a href="{{ route('topics.show', $activity->loggable) }}"
                                                            class="inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                                            View Topic <svg class="ml-1 w-3 h-3" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M9 5l7 7-7 7" />
                                                            </svg>
                                                        </a>
                                                    @elseif($activity->loggable_type === 'App\\Models\\Certificate')
                                                        <a href="{{ route('certificates.show', $activity->loggable) }}"
                                                            class="inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                                            View Certificate <svg class="ml-1 w-3 h-3" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M9 5l7 7-7 7" />
                                                            </svg>
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-8 flex justify-center">
                        {{ $activities->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app-with-sidebar>
