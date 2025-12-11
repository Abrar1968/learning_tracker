<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('My Roadmaps') }}
            </h2>
            <a href="{{ route('roadmaps.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm hover:shadow">
                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create Roadmap
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Tabs -->
            <div class="mb-8 overflow-x-auto">
                <nav class="flex space-x-2 p-1 bg-slate-100 rounded-xl w-fit">
                    <a href="{{ route('roadmaps.index') }}"
                        class="{{ !request('status') ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700' }} px-4 py-2 rounded-lg text-sm font-medium transition-all">
                        All
                    </a>
                    <a href="{{ route('roadmaps.index', ['status' => 'in_progress']) }}"
                        class="{{ request('status') === 'in_progress' ? 'bg-white text-blue-700 shadow-sm' : 'text-slate-500 hover:text-slate-700' }} px-4 py-2 rounded-lg text-sm font-medium transition-all">
                        In Progress
                    </a>
                    <a href="{{ route('roadmaps.index', ['status' => 'completed']) }}"
                        class="{{ request('status') === 'completed' ? 'bg-white text-green-700 shadow-sm' : 'text-slate-500 hover:text-slate-700' }} px-4 py-2 rounded-lg text-sm font-medium transition-all">
                        Completed
                    </a>
                    <a href="{{ route('roadmaps.index', ['status' => 'not_started']) }}"
                        class="{{ request('status') === 'not_started' ? 'bg-white text-slate-700 shadow-sm' : 'text-slate-500 hover:text-slate-700' }} px-4 py-2 rounded-lg text-sm font-medium transition-all">
                        Not Started
                    </a>
                </nav>
            </div>

            <!-- Roadmaps Grid -->
            @if ($roadmaps->isEmpty())
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="mt-2 text-lg font-medium text-slate-900">No roadmaps found</h3>
                    <p class="mt-1 text-slate-500">Get started by creating a new learning path.</p>
                    <div class="mt-6">
                        <a href="{{ route('roadmaps.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            Create Roadmap
                        </a>
                    </div>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($roadmaps as $roadmap)
                        <div
                            class="bg-white rounded-2xl shadow-sm border border-slate-200 hover:shadow-md transition-all duration-200 flex flex-col h-full group">
                            <div class="p-6 flex-1 flex flex-col">
                                <!-- Status Badge -->
                                <div class="flex items-center justify-between mb-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ring-1 ring-inset
                                        @if ($roadmap->status === 'completed') bg-green-50 text-green-700 ring-green-600/20
                                        @elseif($roadmap->status === 'in_progress') bg-blue-50 text-blue-700 ring-blue-700/10
                                        @else bg-slate-50 text-slate-600 ring-slate-500/10 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $roadmap->status)) }}
                                    </span>
                                    <span class="text-xs text-slate-400">
                                        {{ $roadmap->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3
                                    class="text-xl font-bold text-slate-900 mb-2 group-hover:text-indigo-600 transition-colors">
                                    <a href="{{ route('roadmaps.show', $roadmap) }}">
                                        {{ $roadmap->title }}
                                    </a>
                                </h3>

                                <!-- Description -->
                                @if ($roadmap->description)
                                    <p class="text-sm text-slate-600 mb-6 line-clamp-2 flex-grow">
                                        {{ $roadmap->description }}
                                    </p>
                                @else
                                    <div class="flex-grow"></div>
                                @endif

                                <!-- Progress Bar -->
                                <div class="mb-5">
                                    <div class="flex justify-between text-xs font-semibold text-slate-500 mb-1.5">
                                        <span>Progress</span>
                                        <span>{{ number_format($roadmap->progress_percentage, 0) }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2">
                                        <div class="bg-indigo-600 h-2 rounded-full transition-all duration-500"
                                            style="width: {{ $roadmap->progress_percentage }}%"></div>
                                    </div>
                                </div>

                                <!-- Stats -->
                                <div
                                    class="flex items-center justify-between text-xs text-slate-500 border-t border-slate-100 pt-4">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <span>{{ $roadmap->completed_topics }}/{{ $roadmap->total_topics }}
                                            Topics</span>
                                    </div>
                                    @if ($roadmap->start_date)
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>{{ $roadmap->start_date->format('M d') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions Footer -->
                            <div
                                class="bg-slate-50 p-4 rounded-b-2xl border-t border-slate-100 flex items-center gap-3">
                                <a href="{{ route('roadmaps.show', $roadmap) }}"
                                    class="flex-1 text-center py-2 px-3 bg-white border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 hover:border-indigo-300 hover:text-indigo-600 transition-colors shadow-sm">
                                    View Details
                                </a>
                                <div class="flex gap-2">
                                    <a href="{{ route('roadmaps.edit', $roadmap) }}"
                                        class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-white rounded-lg transition-colors"
                                        title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    @if ($roadmap->status === 'completed' && !$roadmap->certificate)
                                        <form action="{{ route('certificates.generate', $roadmap) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="p-2 text-green-500 hover:text-green-700 hover:bg-white rounded-lg transition-colors"
                                                title="Generate Certificate">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $roadmaps->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
