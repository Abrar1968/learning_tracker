<x-layouts.app-with-sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('reviews.index') }}" class="p-2 bg-gray-100 dark:bg-dark-700 rounded-xl hover:bg-gray-200 dark:hover:bg-dark-600 transition-colors">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div class="p-2 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Review Session</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Test your knowledge</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Review Card -->
            <div class="bg-white dark:bg-dark-800 rounded-2xl shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-8 text-white text-center">
                    <p class="text-white/70 text-sm mb-2">
                        {{ $review->topic ? 'Topic' : 'Resource' }} Review
                    </p>
                    <h3 class="text-2xl font-bold">
                        {{ $review->topic?->title ?? $review->resource?->title ?? 'Unknown Item' }}
                    </h3>
                    @if($review->topic?->roadmap ?? $review->resource?->topic?->roadmap)
                        <p class="text-white/70 text-sm mt-2">
                            From: {{ $review->topic?->roadmap?->title ?? $review->resource?->topic?->roadmap?->title }}
                        </p>
                    @endif
                </div>

                <!-- Content/Notes -->
                <div class="p-8">
                    @if($review->topic)
                        @if($review->topic->description)
                            <div class="mb-6">
                                <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Description</h4>
                                <p class="text-gray-700 dark:text-gray-300">{{ $review->topic->description }}</p>
                            </div>
                        @endif

                        @if($review->topic->notes)
                            <div class="mb-6">
                                <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Your Notes</h4>
                                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                                    <p class="text-gray-700 dark:text-gray-300">{{ $review->topic->notes }}</p>
                                </div>
                            </div>
                        @endif
                    @elseif($review->resource)
                        @if($review->resource->description)
                            <div class="mb-6">
                                <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Description</h4>
                                <p class="text-gray-700 dark:text-gray-300">{{ $review->resource->description }}</p>
                            </div>
                        @endif

                        @if($review->resource->url)
                            <div class="mb-6">
                                <a href="{{ $review->resource->url }}" target="_blank" class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:underline">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                    Open Resource
                                </a>
                            </div>
                        @endif
                    @endif

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 mb-8 p-4 bg-gray-50 dark:bg-dark-700 rounded-xl">
                        <div class="text-center">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Reviews</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $review->repetition_count }}</p>
                        </div>
                        <div class="text-center border-x border-gray-200 dark:border-dark-600">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Interval</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $review->interval_days }} days</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Ease Factor</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ number_format($review->easiness_factor, 1) }}</p>
                        </div>
                    </div>

                    <!-- Rating Section -->
                    <div class="text-center">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">How well did you remember this?</h4>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">Rate your recall quality to optimize future review timing</p>

                        <form action="{{ route('reviews.record', $review) }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-6 gap-2 mb-6">
                                @php
                                    $ratings = [
                                        0 => ['label' => 'Forgot', 'color' => 'bg-red-500', 'desc' => 'Complete blackout'],
                                        1 => ['label' => 'Wrong', 'color' => 'bg-orange-500', 'desc' => 'Wrong answer'],
                                        2 => ['label' => 'Hard', 'color' => 'bg-yellow-500', 'desc' => 'With difficulty'],
                                        3 => ['label' => 'OK', 'color' => 'bg-lime-500', 'desc' => 'With hesitation'],
                                        4 => ['label' => 'Good', 'color' => 'bg-green-500', 'desc' => 'Correct'],
                                        5 => ['label' => 'Easy', 'color' => 'bg-emerald-500', 'desc' => 'Perfect!'],
                                    ];
                                @endphp

                                @foreach($ratings as $value => $rating)
                                    <button type="submit" name="quality" value="{{ $value }}"
                                            class="p-4 rounded-xl {{ $rating['color'] }} text-white font-bold hover:scale-105 hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ str_replace('bg-', '', $rating['color']) }}">
                                        <span class="block text-2xl mb-1">{{ $value }}</span>
                                        <span class="block text-xs">{{ $rating['label'] }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </form>

                        <div class="bg-gray-50 dark:bg-dark-700 rounded-xl p-4">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Rating Guide:</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-xs text-gray-600 dark:text-gray-400">
                                @foreach($ratings as $value => $rating)
                                    <div class="flex items-center">
                                        <span class="w-5 h-5 {{ $rating['color'] }} rounded text-white text-center mr-2">{{ $value }}</span>
                                        <span>{{ $rating['desc'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-dark-700/50 border-t border-gray-200 dark:border-dark-600 flex justify-between items-center">
                    <div class="flex space-x-2">
                        <form action="{{ route('reviews.suspend', $review) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 text-sm">
                                Suspend
                            </button>
                        </form>
                        <span class="text-gray-300 dark:text-gray-600">|</span>
                        <form action="{{ route('reviews.reset', $review) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 text-sm" onclick="return confirm('Reset progress for this item?')">
                                Reset Progress
                            </button>
                        </form>
                    </div>
                    <a href="{{ route('reviews.index') }}" class="text-indigo-600 dark:text-indigo-400 font-semibold text-sm hover:underline">
                        Skip for now
                    </a>
                </div>
            </div>

            <!-- Keyboard Shortcuts Hint -->
            <div class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
                <p>Tip: Press <kbd class="px-2 py-1 bg-gray-200 dark:bg-dark-700 rounded">0</kbd> - <kbd class="px-2 py-1 bg-gray-200 dark:bg-dark-700 rounded">5</kbd> to quickly rate your recall</p>
            </div>
        </div>
    </div>

    <script>
        // Keyboard shortcuts for rating
        document.addEventListener('keydown', function(e) {
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;

            const key = parseInt(e.key);
            if (key >= 0 && key <= 5) {
                const form = document.querySelector('form[action*="record"]');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'quality';
                input.value = key;
                form.appendChild(input);
                form.submit();
            }
        });
    </script>
</x-layouts.app-with-sidebar>
