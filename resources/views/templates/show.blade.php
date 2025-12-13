<x-layouts.app-with-sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('templates.index') }}" class="p-2 bg-gray-100 dark:bg-dark-700 rounded-xl hover:bg-gray-200 dark:hover:bg-dark-600 transition-colors">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <span class="text-3xl">{{ $template->icon ?? '📚' }}</span>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $template->name }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ \App\Models\RoadmapTemplate::CATEGORIES[$template->category] ?? $template->category }}</p>
                </div>
            </div>
            <form action="{{ route('templates.clone', $template) }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl font-semibold text-sm text-white shadow-lg hover:shadow-xl transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Use This Template
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Description -->
                    <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">About This Template</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            {{ $template->description }}
                        </p>
                    </div>

                    <!-- Structure Preview -->
                    <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">What's Included</h3>

                        @if($template->structure && isset($template->structure['topics']))
                            <div class="space-y-3">
                                @foreach($template->structure['topics'] as $index => $topic)
                                    <div class="border border-gray-200 dark:border-dark-600 rounded-lg p-4">
                                        <div class="flex items-start">
                                            <span class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center font-bold text-sm mr-3 flex-shrink-0">
                                                {{ $index + 1 }}
                                            </span>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ $topic['title'] }}</h4>
                                                @if(isset($topic['description']))
                                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $topic['description'] }}</p>
                                                @endif
                                                @if(isset($topic['estimated_hours']))
                                                    <p class="text-xs text-indigo-600 dark:text-indigo-400 mt-2">
                                                        Estimated: {{ $topic['estimated_hours'] }} hours
                                                    </p>
                                                @endif
                                                @if(isset($topic['resources']) && count($topic['resources']) > 0)
                                                    <div class="mt-3 pl-4 border-l-2 border-gray-200 dark:border-dark-600">
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Resources:</p>
                                                        <ul class="space-y-1">
                                                            @foreach($topic['resources'] as $resource)
                                                                <li class="text-sm text-gray-600 dark:text-gray-300 flex items-center">
                                                                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-2"></span>
                                                                    {{ $resource['title'] }}
                                                                    @if(isset($resource['type']))
                                                                        <span class="ml-2 px-2 py-0.5 bg-gray-100 dark:bg-dark-700 text-gray-500 dark:text-gray-400 text-xs rounded">{{ $resource['type'] }}</span>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">No structure preview available.</p>
                        @endif
                    </div>

                    <!-- Rating Section -->
                    <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Rate This Template</h3>
                        <form action="{{ route('templates.rate', $template) }}" method="POST" class="flex items-center space-x-4">
                            @csrf
                            <div x-data="{ rating: 0, hoverRating: 0 }" class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button"
                                            @click="rating = {{ $i }}"
                                            @mouseenter="hoverRating = {{ $i }}"
                                            @mouseleave="hoverRating = 0"
                                            class="p-1 focus:outline-none transition-transform hover:scale-110">
                                        <svg class="w-8 h-8"
                                             :class="(hoverRating || rating) >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300 dark:text-dark-600'"
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </button>
                                @endfor
                                <input type="hidden" name="rating" x-model="rating">
                            </div>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-semibold text-sm hover:bg-indigo-700 transition-colors">
                                Submit Rating
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Template Info -->
                    <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Template Details</h3>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Category</span>
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ \App\Models\RoadmapTemplate::CATEGORIES[$template->category] ?? $template->category }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Difficulty</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $template->difficulty === 'beginner' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                    {{ $template->difficulty === 'intermediate' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                    {{ $template->difficulty === 'advanced' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}
                                    {{ $template->difficulty === 'expert' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' : '' }}">
                                    {{ ucfirst($template->difficulty) }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Rating</span>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="font-bold text-gray-900 dark:text-white">{{ number_format($template->rating, 1) }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Times Used</span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $template->clone_count }}</span>
                            </div>
                            @if($template->estimated_hours)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Est. Duration</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $template->estimated_hours }} hours</span>
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-dark-600">
                            <form action="{{ route('templates.clone', $template) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition-colors">
                                    Use This Template
                                </button>
                            </form>
                            <p class="text-xs text-gray-500 dark:text-gray-400 text-center mt-2">
                                Creates a new roadmap from this template
                            </p>
                        </div>
                    </div>

                    <!-- Created By -->
                    @if($template->creator)
                        <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6">
                            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Created By</h3>
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-indigo-600 dark:text-indigo-400 font-bold text-lg">
                                        {{ substr($template->creator->name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $template->creator->name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Template Creator</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Related Templates -->
            @if($relatedTemplates->isNotEmpty())
                <div class="mt-12">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Related Templates</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedTemplates as $related)
                            <a href="{{ route('templates.show', $related) }}" class="bg-white dark:bg-dark-800 rounded-xl shadow p-5 hover:shadow-lg transition-shadow">
                                <div class="flex items-center mb-3">
                                    <span class="text-2xl mr-2">{{ $related->icon ?? '📚' }}</span>
                                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $related->name }}</h4>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2">{{ $related->description }}</p>
                                <div class="flex items-center justify-between mt-3 text-xs text-gray-400">
                                    <span class="flex items-center">
                                        <svg class="w-3 h-3 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        {{ number_format($related->rating, 1) }}
                                    </span>
                                    <span>{{ $related->clone_count }} uses</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app-with-sidebar>
