<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Activity Feed
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($activities->isEmpty())
                    <p class="text-gray-500 text-center py-8">No activity yet. Start learning to see your progress here!</p>
                @else
                    <div class="space-y-6">
                        @foreach($activities as $activity)
                            <div class="flex items-start space-x-4 pb-6 border-b border-gray-200 last:border-0">
                                <!-- Icon -->
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                        @switch($activity->action)
                                            @case('roadmap_created')
                                                <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                                @break
                                            @case('roadmap_completed')
                                            @case('topic_completed')
                                                <svg class="h-6 w-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                @break
                                            @case('certificate_generated')
                                                <svg class="h-6 w-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                @break
                                            @default
                                                <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                </svg>
                                        @endswitch
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ ucfirst(str_replace('_', ' ', $activity->action)) }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $activity->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600">
                                        {{ $activity->description }}
                                    </p>

                                    <!-- Related Entity Link -->
                                    @if($activity->loggable)
                                        <div class="mt-2">
                                            @if($activity->loggable_type === 'App\\Models\\Roadmap')
                                                <a href="{{ route('roadmaps.show', $activity->loggable) }}" 
                                                   class="text-sm text-indigo-600 hover:text-indigo-800">
                                                    View roadmap →
                                                </a>
                                            @elseif($activity->loggable_type === 'App\\Models\\Topic')
                                                <a href="{{ route('topics.show', $activity->loggable) }}" 
                                                   class="text-sm text-indigo-600 hover:text-indigo-800">
                                                    View topic →
                                                </a>
                                            @elseif($activity->loggable_type === 'App\\Models\\Certificate')
                                                <a href="{{ route('certificates.show', $activity->loggable) }}" 
                                                   class="text-sm text-indigo-600 hover:text-indigo-800">
                                                    View certificate →
                                                </a>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Metadata -->
                                    @if(!empty($activity->metadata))
                                        <div class="mt-2 text-xs text-gray-500">
                                            @foreach($activity->metadata as $key => $value)
                                                <span class="mr-3">{{ ucfirst($key) }}: {{ $value }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $activities->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
