<x-layouts.app-with-sidebar>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Template Gallery</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Browse and use learning path templates</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search & Filters -->
            <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6 mb-8">
                <form method="GET" action="{{ route('templates.index') }}" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <input type="text"
                               name="q"
                               value="{{ $query ?? '' }}"
                               placeholder="Search templates..."
                               class="w-full rounded-lg border-gray-300 dark:border-dark-600 dark:bg-dark-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <select name="category" class="rounded-lg border-gray-300 dark:border-dark-600 dark:bg-dark-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Categories</option>
                            @foreach(\App\Models\RoadmapTemplate::CATEGORIES as $key => $label)
                                <option value="{{ $key }}" {{ ($category ?? '') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="difficulty" class="rounded-lg border-gray-300 dark:border-dark-600 dark:bg-dark-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Difficulties</option>
                            @foreach(\App\Models\RoadmapTemplate::DIFFICULTIES as $key => $label)
                                <option value="{{ $key }}" {{ ($difficulty ?? '') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
                        Search
                    </button>
                </form>
            </div>

            <!-- Featured Templates -->
            @if(isset($featured) && $featured->isNotEmpty() && !$query && !$category && !$difficulty)
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Featured Templates</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($featured as $template)
                            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-lg p-6 text-white relative overflow-hidden">
                                <div class="absolute top-0 right-0 bg-yellow-400 text-yellow-900 px-3 py-1 text-xs font-bold rounded-bl-lg">
                                    Featured
                                </div>
                                <div class="flex items-center mb-4">
                                    <span class="text-3xl mr-3">{{ $template->icon ?? '📚' }}</span>
                                    <div>
                                        <h4 class="font-bold text-lg">{{ $template->name }}</h4>
                                        <p class="text-white/70 text-sm">{{ \App\Models\RoadmapTemplate::CATEGORIES[$template->category] ?? $template->category }}</p>
                                    </div>
                                </div>
                                <p class="text-white/80 text-sm mb-4 line-clamp-2">{{ $template->description }}</p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3 text-sm">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            {{ number_format($template->rating, 1) }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $template->clone_count }}
                                        </span>
                                    </div>
                                    <a href="{{ route('templates.show', $template) }}" class="px-4 py-2 bg-white text-indigo-600 rounded-lg font-semibold text-sm hover:bg-gray-100 transition-colors">
                                        View
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Categories -->
            @if(isset($categories) && count($categories) > 0 && !$query && !$category && !$difficulty)
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Browse by Category</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        @foreach($categories as $catKey => $catData)
                            @if($catData['count'] > 0)
                                <a href="{{ route('templates.index', ['category' => $catKey]) }}"
                                   class="bg-white dark:bg-dark-800 rounded-xl shadow p-4 text-center hover:shadow-lg hover:scale-105 transition-all">
                                    <p class="text-2xl mb-2">{{ \App\Models\RoadmapTemplate::CATEGORY_ICONS[$catKey] ?? '📁' }}</p>
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $catData['name'] }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $catData['count'] }} templates</p>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- All Templates -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                    @if($query || $category || $difficulty)
                        Search Results
                    @else
                        All Templates
                    @endif
                </h3>

                @if($templates->isEmpty())
                    <div class="bg-white dark:bg-dark-800 rounded-xl shadow p-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-dark-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No templates found</h4>
                        <p class="text-gray-500 dark:text-gray-400">Try adjusting your search or filters.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($templates as $template)
                            <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                                <div class="p-6">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center">
                                            <span class="text-2xl mr-3">{{ $template->icon ?? '📚' }}</span>
                                            <div>
                                                <h4 class="font-bold text-gray-900 dark:text-white">{{ $template->name }}</h4>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ \App\Models\RoadmapTemplate::CATEGORIES[$template->category] ?? $template->category }}
                                                </p>
                                            </div>
                                        </div>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $template->difficulty === 'beginner' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                            {{ $template->difficulty === 'intermediate' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                            {{ $template->difficulty === 'advanced' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}
                                            {{ $template->difficulty === 'expert' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' : '' }}">
                                            {{ ucfirst($template->difficulty) }}
                                        </span>
                                    </div>

                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                                        {{ $template->description }}
                                    </p>

                                    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center space-x-4">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                                {{ number_format($template->rating, 1) }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                                {{ $template->clone_count }} clones
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-6 py-4 bg-gray-50 dark:bg-dark-700/50 border-t border-gray-200 dark:border-dark-600 flex justify-between">
                                    <a href="{{ route('templates.show', $template) }}" class="text-indigo-600 dark:text-indigo-400 font-semibold text-sm hover:underline">
                                        View Details
                                    </a>
                                    <form action="{{ route('templates.clone', $template) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-4 py-1.5 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors">
                                            Use Template
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $templates->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app-with-sidebar>
