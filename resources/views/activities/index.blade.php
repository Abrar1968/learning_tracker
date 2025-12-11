<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Activity Feed') }}
            </h2>
            <div class="text-sm text-slate-500">
                Tracking your learning journey
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-8">
                @if ($activities->isEmpty())
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-2 text-lg font-medium text-slate-900">No activity recorded</h3>
                        <p class="mt-1 text-slate-500">Start your learning journey to see your progress here.</p>
                        <div class="mt-6">
                            <a href="{{ route('roadmaps.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                                Start Learning
                            </a>
                        </div>
                    </div>
                @else
                    <div class="relative">
                        <!-- Connecting Line -->
                        <div class="absolute top-0 bottom-0 left-8 w-px bg-slate-200"></div>

                        <div class="space-y-8 relative">
                            @foreach ($activities as $activity)
                                <div class="relative flex items-start group">
                                    <!-- Timeline Icon -->
                                    <div class="flex items-center justify-center w-16 flex-shrink-0">
                                        <div
                                            class="relative z-10 flex items-center justify-center w-10 h-10 bg-white rounded-full border-2 border-white shadow-sm ring-1 ring-slate-200 group-hover:ring-indigo-200 transition-all">
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
                                            class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
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
</x-app-layout>
