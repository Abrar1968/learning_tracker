<x-layouts.app-with-sidebar>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 leading-tight mb-1">
                    {{ __('My Roadmaps') }}
                </h2>
                <p class="text-sm text-gray-600">Track and manage your learning journey</p>
            </div>
            <a href="{{ route('roadmaps.create') }}"
                class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-wide hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                <svg class="-ml-1 mr-2 h-5 w-5 transition-transform group-hover:rotate-90 duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create Roadmap
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Tabs -->
            <div class="mb-8 overflow-x-auto">
                <nav class="flex space-x-2 p-1.5 bg-white rounded-2xl w-fit shadow-lg border border-gray-200">
                    <a href="{{ route('roadmaps.index') }}"
                        class="{{ !request('status') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} px-6 py-3 rounded-xl text-sm font-bold transition-all duration-300 transform hover:scale-105">
                        All
                    </a>
                    <a href="{{ route('roadmaps.index', ['status' => 'in_progress']) }}"
                        class="{{ request('status') === 'in_progress' ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} px-6 py-3 rounded-xl text-sm font-bold transition-all duration-300 transform hover:scale-105">
                        In Progress
                    </a>
                    <a href="{{ route('roadmaps.index', ['status' => 'completed']) }}"
                        class="{{ request('status') === 'completed' ? 'bg-gradient-to-r from-green-600 to-emerald-600 text-white shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} px-6 py-3 rounded-xl text-sm font-bold transition-all duration-300 transform hover:scale-105">
                        Completed
                    </a>
                    <a href="{{ route('roadmaps.index', ['status' => 'not_started']) }}"
                        class="{{ request('status') === 'not_started' ? 'bg-gradient-to-r from-gray-600 to-gray-700 text-white shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} px-6 py-3 rounded-xl text-sm font-bold transition-all duration-300 transform hover:scale-105">
                        Not Started
                    </a>
                </nav>
            </div>

            <!-- Roadmaps Grid -->
            @if ($roadmaps->isEmpty())
                <div class="bg-white rounded-3xl shadow-xl border border-gray-200 p-16 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600"></div>
                    <div class="w-24 h-24 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse">
                        <svg class="h-12 w-12 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">No roadmaps found</h3>
                    <p class="text-lg text-gray-600 mb-8">Get started by creating your first learning path and track your progress!</p>
                    <a href="{{ route('roadmaps.create') }}"
                        class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-wide hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <svg class="-ml-1 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create Your First Roadmap
                    </a>
                </div>
            @else
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($roadmaps as $roadmap)
                        <div class="group bg-white rounded-3xl shadow-xl border border-gray-200 hover:shadow-2xl hover:border-indigo-300 transition-all duration-500 flex flex-col h-full overflow-hidden transform hover:-translate-y-2">
                            <!-- Gradient Top Border -->
                            <div class="h-2 bg-gradient-to-r {{ $roadmap->status === 'completed' ? 'from-green-400 via-emerald-500 to-teal-500' : ($roadmap->status === 'in_progress' ? 'from-blue-400 via-indigo-500 to-purple-500' : 'from-gray-400 via-gray-500 to-gray-600') }}"></div>

                            <div class="p-8 flex-1 flex flex-col">
                                <!-- Status Badge & Date -->
                                <div class="flex items-center justify-between mb-5">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-bold shadow-md {{ $roadmap->status === 'completed' ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-700' : ($roadmap->status === 'in_progress' ? 'bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700' : 'bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700') }}">
                                        {{ ucfirst(str_replace('_', ' ', $roadmap->status)) }}
                                    </span>
                                    <span class="text-xs text-gray-500 font-medium bg-gray-100 px-3 py-1.5 rounded-full">
                                        {{ $roadmap->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3 class="text-2xl font-black text-gray-900 mb-3 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-indigo-600 group-hover:to-purple-600 transition-all duration-300">
                                    <a href="{{ route('roadmaps.show', $roadmap) }}">
                                        {{ $roadmap->title }}
                                    </a>
                                </h3>

                                <!-- Description -->
                                @if ($roadmap->description)
                                    <p class="text-sm text-gray-600 mb-6 line-clamp-2 flex-grow leading-relaxed">
                                        {{ $roadmap->description }}
                                    </p>
                                @else
                                    <div class="flex-grow"></div>
                                @endif

                                <!-- Progress Bar -->
                                <div class="mb-6 bg-gray-50 rounded-xl p-4">
                                    <div class="flex justify-between text-sm font-bold text-gray-700 mb-3">
                                        <span>Progress</span>
                                        <span class="text-indigo-600">{{ number_format($roadmap->progress_percentage, 0) }}%</span>
                                    </div>
                                    <div class="relative w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-full transition-all duration-1000 ease-out" style="width: {{ $roadmap->progress_percentage }}%"></div>
                                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-30 animate-pulse"></div>
                                    </div>
                                </div>

                                <!-- Stats -->
                                <div class="flex items-center justify-between text-sm text-gray-600 border-t-2 border-gray-100 pt-5">
                                    <div class="flex items-center gap-2 bg-indigo-50 px-4 py-2 rounded-lg">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <span class="font-bold">{{ $roadmap->completed_topics }}/{{ $roadmap->total_topics }}</span>
                                    </div>
                                    @if ($roadmap->start_date)
                                        <div class="flex items-center gap-2 bg-purple-50 px-4 py-2 rounded-lg">
                                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="font-bold">{{ $roadmap->start_date->format('M d') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions Footer -->
                            <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 border-t border-gray-200 flex items-center gap-4">
                                <a href="{{ route('roadmaps.show', $roadmap) }}"
                                    class="flex-1 text-center py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl text-sm font-bold text-white hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                    View Details
                                </a>
                                <div class="flex gap-2">
                                    <a href="{{ route('roadmaps.edit', $roadmap) }}"
                                        class="p-3 text-gray-600 hover:text-indigo-600 bg-white hover:bg-indigo-50 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-110"
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
                                                class="p-3 text-green-600 hover:text-white bg-white hover:bg-green-600 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-110"
                                                title="Generate Certificate">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
</x-layouts.app-with-sidebar>
