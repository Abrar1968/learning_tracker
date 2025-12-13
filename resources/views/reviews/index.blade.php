<x-layouts.app-with-sidebar>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Spaced Repetition</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Review and retain knowledge</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white dark:bg-dark-800 rounded-xl shadow p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Due Today</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['due_today'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-dark-800 rounded-xl shadow p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Reviewed Today</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['reviewed_today'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-dark-800 rounded-xl shadow p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Items</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_items'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-dark-800 rounded-xl shadow p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Retention Rate</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['retention_rate'] ?? 0 }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Due Reviews -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-dark-700 flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Due for Review</h3>
                            @if($dueReviews->isNotEmpty())
                                <a href="{{ route('reviews.show', $dueReviews->first()) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg font-semibold text-sm hover:bg-green-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Start Review
                                </a>
                            @endif
                        </div>

                        @if($dueReviews->isEmpty())
                            <div class="p-12 text-center">
                                <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">All caught up!</h4>
                                <p class="text-gray-500 dark:text-gray-400">No reviews due right now. Check back later or add new items.</p>
                            </div>
                        @else
                            <div class="divide-y divide-gray-200 dark:divide-dark-700">
                                @foreach($dueReviews as $review)
                                    <div class="p-4 hover:bg-gray-50 dark:hover:bg-dark-700/50 transition-colors">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-4">
                                                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $review->topic ? 'bg-blue-100 dark:bg-blue-900/30' : 'bg-purple-100 dark:bg-purple-900/30' }}">
                                                    @if($review->topic)
                                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-900 dark:text-white">
                                                        {{ $review->topic?->title ?? $review->resource?->title ?? 'Unknown' }}
                                                    </p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        Due {{ $review->next_review_date->diffForHumans() }} •
                                                        Interval: {{ $review->interval_days }} days
                                                    </p>
                                                </div>
                                            </div>
                                            <a href="{{ route('reviews.show', $review) }}" class="px-4 py-2 bg-gray-100 dark:bg-dark-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-semibold hover:bg-gray-200 dark:hover:bg-dark-600 transition-colors">
                                                Review
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Upcoming Reviews -->
                    @if($upcomingReviews->isNotEmpty())
                        <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg overflow-hidden mt-8">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-dark-700">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Coming Up</h3>
                            </div>
                            <div class="divide-y divide-gray-200 dark:divide-dark-700">
                                @foreach($upcomingReviews as $review)
                                    <div class="p-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <span class="text-gray-400 dark:text-gray-500 text-sm">{{ $review->next_review_date->format('M j') }}</span>
                                                <p class="text-gray-900 dark:text-white">
                                                    {{ $review->topic?->title ?? $review->resource?->title ?? 'Unknown' }}
                                                </p>
                                            </div>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $review->next_review_date->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Review Calendar -->
                    <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Review Calendar</h3>
                        <div class="grid grid-cols-7 gap-1 text-center text-xs mb-2">
                            @foreach(['S', 'M', 'T', 'W', 'T', 'F', 'S'] as $day)
                                <div class="text-gray-500 dark:text-gray-400 font-semibold py-1">{{ $day }}</div>
                            @endforeach
                        </div>
                        <div class="grid grid-cols-7 gap-1">
                            @php
                                $startOfMonth = now()->startOfMonth();
                                $startDayOfWeek = $startOfMonth->dayOfWeek;
                                $daysInMonth = now()->daysInMonth;
                            @endphp

                            @for($i = 0; $i < $startDayOfWeek; $i++)
                                <div class="aspect-square"></div>
                            @endfor

                            @for($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $date = now()->startOfMonth()->addDays($day - 1)->format('Y-m-d');
                                    $count = $calendar[$date] ?? 0;
                                    $isToday = now()->format('Y-m-d') === $date;
                                @endphp
                                <div class="aspect-square flex items-center justify-center text-xs rounded-lg
                                    {{ $isToday ? 'ring-2 ring-indigo-500' : '' }}
                                    {{ $count > 0 ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 font-semibold' : 'text-gray-400 dark:text-gray-500' }}">
                                    {{ $day }}
                                </div>
                            @endfor
                        </div>
                        <div class="mt-4 flex items-center justify-center space-x-4 text-xs">
                            <span class="flex items-center">
                                <span class="w-3 h-3 bg-green-100 dark:bg-green-900/30 rounded mr-1"></span>
                                <span class="text-gray-500 dark:text-gray-400">Has reviews</span>
                            </span>
                        </div>
                    </div>

                    <!-- How It Works -->
                    <div class="bg-gradient-to-br from-green-500 to-teal-600 rounded-xl shadow-lg p-6 text-white">
                        <h3 class="text-lg font-bold mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            How It Works
                        </h3>
                        <ul class="text-sm text-white/90 space-y-3">
                            <li class="flex items-start">
                                <span class="w-5 h-5 bg-white/20 rounded-full flex items-center justify-center mr-2 flex-shrink-0 text-xs">1</span>
                                <span>Add topics/resources to your review queue</span>
                            </li>
                            <li class="flex items-start">
                                <span class="w-5 h-5 bg-white/20 rounded-full flex items-center justify-center mr-2 flex-shrink-0 text-xs">2</span>
                                <span>Review items when they're due</span>
                            </li>
                            <li class="flex items-start">
                                <span class="w-5 h-5 bg-white/20 rounded-full flex items-center justify-center mr-2 flex-shrink-0 text-xs">3</span>
                                <span>Rate your recall (0-5 scale)</span>
                            </li>
                            <li class="flex items-start">
                                <span class="w-5 h-5 bg-white/20 rounded-full flex items-center justify-center mr-2 flex-shrink-0 text-xs">4</span>
                                <span>SM-2 algorithm optimizes intervals</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6">
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Quick Actions</h3>
                        <div class="space-y-2">
                            <a href="{{ route('roadmaps.index') }}" class="flex items-center px-4 py-3 bg-gray-50 dark:bg-dark-700 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-600 transition-colors">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Add from Roadmaps
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app-with-sidebar>
