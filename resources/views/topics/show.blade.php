<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $topic->title }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    <a href="{{ route('roadmaps.show', $topic->roadmap) }}" class="hover:text-indigo-600">
                        {{ $topic->roadmap->title }}
                    </a>
                </p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('resources.create', ['topic_id' => $topic->id]) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                    Add Resource
                </a>
                <a href="{{ route('topics.edit', $topic) }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded text-sm">
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Topic Details -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($topic->status === 'completed') bg-green-100 text-green-800
                                @elseif($topic->status === 'in_progress') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $topic->status)) }}
                            </span>
                            @if($topic->parent)
                                <span class="text-sm text-gray-500">
                                    Subtopic of <a href="{{ route('topics.show', $topic->parent) }}" class="text-indigo-600 hover:text-indigo-800">{{ $topic->parent->title }}</a>
                                </span>
                            @endif
                        </div>

                        @if($topic->description)
                            <h3 class="text-lg font-semibold mb-2">Description</h3>
                            <p class="text-gray-600 mb-4">{{ $topic->description }}</p>
                        @endif

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            @if($topic->estimated_hours)
                                <div>
                                    <span class="font-medium text-gray-700">Estimated Hours:</span>
                                    <span class="text-gray-600">{{ $topic->estimated_hours }}h</span>
                                </div>
                            @endif
                            @if($topic->actual_hours)
                                <div>
                                    <span class="font-medium text-gray-700">Actual Hours:</span>
                                    <span class="text-gray-600">{{ $topic->actual_hours }}h</span>
                                </div>
                            @endif
                            <div>
                                <span class="font-medium text-gray-700">Resources:</span>
                                <span class="text-gray-600">{{ $topic->resources->count() }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Subtopics:</span>
                                <span class="text-gray-600">{{ $topic->children->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Resources -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">Resources ({{ $topic->resources->count() }})</h3>
                        
                        @if($topic->resources->isEmpty())
                            <p class="text-gray-500 text-center py-4">No resources yet.</p>
                        @else
                            <div class="space-y-3">
                                @foreach($topic->resources as $resource)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-2 mb-2">
                                                    <!-- Resource Type Icon -->
                                                    @switch($resource->type)
                                                        @case('video')
                                                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                                            </svg>
                                                            @break
                                                        @case('article')
                                                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                                            </svg>
                                                            @break
                                                        @case('book')
                                                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                                            </svg>
                                                            @break
                                                        @case('course')
                                                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                                            </svg>
                                                            @break
                                                        @case('documentation')
                                                            <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                                            </svg>
                                                            @break
                                                        @default
                                                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                                            </svg>
                                                    @endswitch
                                                    
                                                    <h4 class="font-semibold text-gray-900">{{ $resource->title }}</h4>
                                                    
                                                    @if($resource->is_completed)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                            ✓ Completed
                                                        </span>
                                                    @endif
                                                </div>

                                                @if($resource->description)
                                                    <p class="text-sm text-gray-600 mb-2">{{ $resource->description }}</p>
                                                @endif

                                                <!-- Tags -->
                                                @if($resource->tags->count() > 0)
                                                    <div class="flex flex-wrap gap-1 mb-2">
                                                        @foreach($resource->tags as $tag)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                                #{{ $tag->tag_name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                <div class="flex items-center space-x-4 text-xs text-gray-500">
                                                    <span>{{ ucfirst($resource->type) }}</span>
                                                    @if($resource->estimated_duration)
                                                        <span>{{ $resource->estimated_duration }} min</span>
                                                    @endif
                                                    @if($resource->file_path && $resource->file_size)
                                                        <span>{{ $resource->getFileSizeFormatted() }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="ml-4 flex flex-col space-y-2">
                                                @if($resource->url)
                                                    <a href="{{ $resource->url }}" target="_blank"
                                                       class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                                        Open →
                                                    </a>
                                                @endif
                                                @if($resource->file_path)
                                                    <a href="{{ Storage::url($resource->file_path) }}" target="_blank"
                                                       class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                                        Download
                                                    </a>
                                                @endif
                                                @if(!$resource->is_completed)
                                                    <form action="{{ route('resources.complete', $resource) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                class="text-green-600 hover:text-green-900 text-sm font-medium">
                                                            Mark Done
                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('resources.edit', $resource) }}" 
                                                   class="text-gray-600 hover:text-gray-900 text-sm">
                                                    Edit
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Subtopics -->
                    @if($topic->children->count() > 0)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">Subtopics ({{ $topic->children->count() }})</h3>
                            <div class="space-y-3">
                                @foreach($topic->children()->orderBy('order')->get() as $subtopic)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <a href="{{ route('topics.show', $subtopic) }}" 
                                                   class="text-gray-900 hover:text-indigo-600 font-medium">
                                                    {{ $subtopic->title }}
                                                </a>
                                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                    @if($subtopic->status === 'completed') bg-green-100 text-green-800
                                                    @elseif($subtopic->status === 'in_progress') bg-blue-100 text-blue-800
                                                    @else bg-gray-100 text-gray-800
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $subtopic->status)) }}
                                                </span>
                                            </div>
                                            <a href="{{ route('topics.show', $subtopic) }}" 
                                               class="text-indigo-600 hover:text-indigo-900 text-sm">
                                                View →
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Progress Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">Progress</h3>
                        
                        @if($topic->progress)
                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-600 mb-2">
                                    <span>Completion</span>
                                    <span class="font-semibold">{{ $topic->progress->getProgressPercentage() }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-indigo-600 h-3 rounded-full transition-all" 
                                         style="width: {{ $topic->progress->getProgressPercentage() }}%"></div>
                                </div>
                            </div>

                            <div class="space-y-3 mb-4 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Time Spent:</span>
                                    <span class="font-medium">{{ floor($topic->progress->time_spent / 60) }}h {{ $topic->progress->time_spent % 60 }}m</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Started:</span>
                                    <span class="font-medium">{{ $topic->progress->started_at->format('M d, Y') }}</span>
                                </div>
                                @if($topic->progress->completed_at)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Completed:</span>
                                        <span class="font-medium">{{ $topic->progress->completed_at->format('M d, Y') }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Resources Done:</span>
                                    <span class="font-medium">{{ $topic->progress->resources_completed }}/{{ $topic->progress->total_resources }}</span>
                                </div>
                            </div>

                            <!-- Notes -->
                            @if($topic->progress->notes)
                                <div class="mb-4">
                                    <h4 class="text-sm font-semibold text-gray-700 mb-1">Notes:</h4>
                                    <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded">{{ $topic->progress->notes }}</p>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="space-y-2">
                                @if(!$topic->progress->isCompleted())
                                    <!-- Log Time Form -->
                                    <form action="{{ route('progress.log-time', $topic->progress) }}" method="POST" 
                                          x-data="{ minutes: '' }"
                                          @submit.prevent="if(minutes) $el.submit()">
                                        @csrf
                                        @method('PATCH')
                                        <div class="flex space-x-2">
                                            <input type="number" 
                                                   name="minutes" 
                                                   x-model="minutes"
                                                   placeholder="Minutes"
                                                   min="1"
                                                   required
                                                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            <button type="submit" 
                                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                                Log Time
                                            </button>
                                        </div>
                                    </form>

                                    <!-- Update Progress Form -->
                                    <form action="{{ route('progress.update', $topic->progress) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                                            Update Progress
                                        </button>
                                    </form>

                                    <!-- Complete Topic -->
                                    <form action="{{ route('progress.complete', $topic->progress) }}" method="POST"
                                          onsubmit="return confirm('Mark this topic as completed?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                            Complete Topic
                                        </button>
                                    </form>
                                @else
                                    <div class="text-center py-4">
                                        <svg class="mx-auto h-12 w-12 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <p class="mt-2 text-sm font-medium text-green-600">Topic Completed!</p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <form action="{{ route('progress.start', $topic) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded">
                                    Start Learning
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
