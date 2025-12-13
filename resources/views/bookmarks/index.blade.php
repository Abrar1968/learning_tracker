<x-layouts.app-with-sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">My Bookmarks</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $counts['total'] ?? 0 }} saved items</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Filters -->
                    <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6">
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Filter By Type</h3>
                        <nav class="space-y-1">
                            <a href="{{ route('bookmarks.index') }}"
                               class="flex items-center justify-between px-3 py-2 rounded-lg {{ !$type ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-dark-700' }}">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                    All
                                </span>
                                <span class="text-xs bg-gray-200 dark:bg-dark-600 px-2 py-0.5 rounded-full">{{ $counts['total'] ?? 0 }}</span>
                            </a>
                            <a href="{{ route('bookmarks.index', ['type' => 'roadmap']) }}"
                               class="flex items-center justify-between px-3 py-2 rounded-lg {{ $type === 'roadmap' ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-dark-700' }}">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                    </svg>
                                    Roadmaps
                                </span>
                                <span class="text-xs bg-gray-200 dark:bg-dark-600 px-2 py-0.5 rounded-full">{{ $counts['roadmaps'] ?? 0 }}</span>
                            </a>
                            <a href="{{ route('bookmarks.index', ['type' => 'topic']) }}"
                               class="flex items-center justify-between px-3 py-2 rounded-lg {{ $type === 'topic' ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-dark-700' }}">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    Topics
                                </span>
                                <span class="text-xs bg-gray-200 dark:bg-dark-600 px-2 py-0.5 rounded-full">{{ $counts['topics'] ?? 0 }}</span>
                            </a>
                            <a href="{{ route('bookmarks.index', ['type' => 'resource']) }}"
                               class="flex items-center justify-between px-3 py-2 rounded-lg {{ $type === 'resource' ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-dark-700' }}">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    Resources
                                </span>
                                <span class="text-xs bg-gray-200 dark:bg-dark-600 px-2 py-0.5 rounded-full">{{ $counts['resources'] ?? 0 }}</span>
                            </a>
                        </nav>
                    </div>

                    <!-- Folders -->
                    @if(count($folders) > 0)
                        <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6">
                            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Folders</h3>
                            <nav class="space-y-1">
                                @foreach($folders as $folderName)
                                    <a href="{{ route('bookmarks.index', ['folder' => $folderName]) }}"
                                       class="flex items-center px-3 py-2 rounded-lg {{ $folder === $folderName ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-dark-700' }}">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                        </svg>
                                        {{ $folderName }}
                                    </a>
                                @endforeach
                            </nav>
                        </div>
                    @endif
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    @if($bookmarks->isEmpty())
                        <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-12 text-center">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-dark-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No bookmarks yet</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">Save topics, resources, and roadmaps for quick access later.</p>
                            <a href="{{ route('roadmaps.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg font-semibold text-sm hover:bg-indigo-700 transition-colors">
                                Browse Roadmaps
                            </a>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($bookmarks as $bookmark)
                                <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-4">
                                            @php
                                                $item = $bookmark->bookmarkable;
                                                $itemType = class_basename($item);
                                            @endphp

                                            <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0
                                                {{ $itemType === 'Roadmap' ? 'bg-blue-100 dark:bg-blue-900/30' : '' }}
                                                {{ $itemType === 'Topic' ? 'bg-green-100 dark:bg-green-900/30' : '' }}
                                                {{ $itemType === 'Resource' ? 'bg-purple-100 dark:bg-purple-900/30' : '' }}">
                                                @if($itemType === 'Roadmap')
                                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                                    </svg>
                                                @elseif($itemType === 'Topic')
                                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                    </svg>
                                                @endif
                                            </div>

                                            <div class="flex-1">
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-xs font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full
                                                        {{ $itemType === 'Roadmap' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                                                        {{ $itemType === 'Topic' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                                        {{ $itemType === 'Resource' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' : '' }}">
                                                        {{ $itemType }}
                                                    </span>
                                                    @if($bookmark->folder)
                                                        <span class="text-xs text-gray-500 dark:text-gray-400">in {{ $bookmark->folder }}</span>
                                                    @endif
                                                </div>

                                                <h4 class="font-semibold text-gray-900 dark:text-white mt-1">
                                                    {{ $item->title ?? $item->name ?? 'Untitled' }}
                                                </h4>

                                                @if($item->description ?? null)
                                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">
                                                        {{ $item->description }}
                                                    </p>
                                                @endif

                                                @if($bookmark->notes)
                                                    <p class="text-sm text-indigo-600 dark:text-indigo-400 mt-2 italic">
                                                        "{{ $bookmark->notes }}"
                                                    </p>
                                                @endif

                                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">
                                                    Bookmarked {{ $bookmark->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-center space-x-2">
                                            @if($itemType === 'Roadmap')
                                                <a href="{{ route('roadmaps.show', $item) }}" class="p-2 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </a>
                                            @elseif($itemType === 'Topic')
                                                <a href="{{ route('topics.show', $item) }}" class="p-2 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </a>
                                            @endif

                                            <form action="{{ route('bookmarks.destroy', $bookmark) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors" onclick="return confirm('Remove this bookmark?')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $bookmarks->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app-with-sidebar>
