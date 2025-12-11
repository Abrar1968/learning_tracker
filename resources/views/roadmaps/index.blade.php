<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Roadmaps
            </h2>
            <a href="{{ route('roadmaps.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                Create Roadmap
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Tabs -->
            <div class="mb-6 border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <a href="{{ route('roadmaps.index') }}"
                       class="{{ !request('status') ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        All
                    </a>
                    <a href="{{ route('roadmaps.index', ['status' => 'in_progress']) }}"
                       class="{{ request('status') === 'in_progress' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        In Progress
                    </a>
                    <a href="{{ route('roadmaps.index', ['status' => 'completed']) }}"
                       class="{{ request('status') === 'completed' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Completed
                    </a>
                    <a href="{{ route('roadmaps.index', ['status' => 'not_started']) }}"
                       class="{{ request('status') === 'not_started' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Not Started
                    </a>
                </nav>
            </div>

            <!-- Roadmaps Grid -->
            @if($roadmaps->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No roadmaps</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new roadmap.</p>
                    <div class="mt-6">
                        <a href="{{ route('roadmaps.create') }}"
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Create Roadmap
                        </a>
                    </div>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($roadmaps as $roadmap)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                            <div class="p-6">
                                <!-- Status Badge -->
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($roadmap->status === 'completed') bg-green-100 text-green-800
                                        @elseif($roadmap->status === 'in_progress') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $roadmap->status)) }}
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        {{ $roadmap->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                    <a href="{{ route('roadmaps.show', $roadmap) }}" class="hover:text-indigo-600">
                                        {{ $roadmap->title }}
                                    </a>
                                </h3>

                                <!-- Description -->
                                @if($roadmap->description)
                                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                        {{ $roadmap->description }}
                                    </p>
                                @endif

                                <!-- Progress Bar -->
                                <div class="mb-4">
                                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                                        <span>Progress</span>
                                        <span>{{ number_format($roadmap->progress_percentage, 0) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-indigo-600 h-2 rounded-full transition-all"
                                             style="width: {{ $roadmap->progress_percentage }}%"></div>
                                    </div>
                                </div>

                                <!-- Stats -->
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                    <span>{{ $roadmap->completed_topics }}/{{ $roadmap->total_topics }} Topics</span>
                                    @if($roadmap->start_date)
                                        <span>Started {{ $roadmap->start_date->format('M d, Y') }}</span>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('roadmaps.show', $roadmap) }}"
                                       class="flex-1 text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                                        View
                                    </a>
                                    <a href="{{ route('roadmaps.edit', $roadmap) }}"
                                       class="flex-1 text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded text-sm">
                                        Edit
                                    </a>
                                    @if($roadmap->status === 'completed' && !$roadmap->certificate)
                                        <form action="{{ route('certificates.generate', $roadmap) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit"
                                                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                                Certificate
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $roadmaps->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
