<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $roadmap->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('topics.create', ['roadmap_id' => $roadmap->id]) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                    Add Topic
                </a>
                <a href="{{ route('roadmaps.edit', $roadmap) }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded text-sm">
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Roadmap Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500 mb-1">Progress</div>
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($roadmap->progress_percentage, 0) }}%</div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                        <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $roadmap->progress_percentage }}%"></div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500 mb-1">Topics</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $roadmap->completed_topics }}/{{ $roadmap->total_topics }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500 mb-1">Status</div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($roadmap->status === 'completed') bg-green-100 text-green-800
                        @elseif($roadmap->status === 'in_progress') bg-blue-100 text-blue-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $roadmap->status)) }}
                    </span>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500 mb-1">Started</div>
                    <div class="text-lg font-bold text-gray-900">
                        @if($roadmap->start_date)
                            {{ $roadmap->start_date->format('M d, Y') }}
                        @else
                            Not started
                        @endif
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($roadmap->description)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-2">Description</h3>
                    <p class="text-gray-600">{{ $roadmap->description }}</p>
                </div>
            @endif

            <!-- Topics List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Topics</h3>
                
                @if($roadmap->topics->isEmpty())
                    <p class="text-gray-500 text-center py-8">No topics yet. Add your first topic to get started!</p>
                @else
                    <div class="space-y-4">
                        @foreach($roadmap->topics()->whereNull('parent_id')->orderBy('order')->get() as $topic)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <h4 class="text-lg font-semibold text-gray-900">
                                                <a href="{{ route('topics.show', $topic) }}" class="hover:text-indigo-600">
                                                    {{ $topic->title }}
                                                </a>
                                            </h4>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($topic->status === 'completed') bg-green-100 text-green-800
                                                @elseif($topic->status === 'in_progress') bg-blue-100 text-blue-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $topic->status)) }}
                                            </span>
                                        </div>
                                        
                                        @if($topic->description)
                                            <p class="text-sm text-gray-600 mb-2">{{ Str::limit($topic->description, 150) }}</p>
                                        @endif

                                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                                            @if($topic->estimated_hours)
                                                <span>📚 {{ $topic->estimated_hours }}h estimated</span>
                                            @endif
                                            <span>📑 {{ $topic->resources->count() }} resources</span>
                                            @if($topic->children->count() > 0)
                                                <span>🔗 {{ $topic->children->count() }} subtopics</span>
                                            @endif
                                        </div>

                                        <!-- Progress bar for topic -->
                                        @if($topic->progress)
                                            <div class="mt-3">
                                                <div class="flex justify-between text-xs text-gray-600 mb-1">
                                                    <span>Progress</span>
                                                    <span>{{ $topic->progress->getProgressPercentage() }}%</span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                    <div class="bg-indigo-600 h-1.5 rounded-full" 
                                                         style="width: {{ $topic->progress->getProgressPercentage() }}%"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="ml-4 flex-shrink-0 flex space-x-2">
                                        <a href="{{ route('topics.show', $topic) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                            View
                                        </a>
                                        <a href="{{ route('topics.edit', $topic) }}" 
                                           class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                                            Edit
                                        </a>
                                    </div>
                                </div>

                                <!-- Subtopics -->
                                @if($topic->children->count() > 0)
                                    <div class="mt-4 ml-6 space-y-2">
                                        @foreach($topic->children()->orderBy('order')->get() as $subtopic)
                                            <div class="border-l-2 border-gray-300 pl-4 py-2">
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
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Certificate Button -->
            @if($roadmap->status === 'completed')
                <div class="mt-6">
                    @if($roadmap->certificate)
                        <a href="{{ route('certificates.show', $roadmap->certificate) }}" 
                           class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            View Certificate
                        </a>
                    @else
                        <form action="{{ route('certificates.generate', $roadmap) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                Generate Certificate
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
