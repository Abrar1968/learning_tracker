<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-3xl text-slate-900 leading-tight">
                    {{ $roadmap->title }}
                </h2>
                @if ($roadmap->description)
                    <p class="mt-2 text-slate-600 max-w-3xl">{{ $roadmap->description }}</p>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('topics.create', ['roadmap_id' => $roadmap->id]) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition shadow-sm">
                    <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Topic
                </a>
                <a href="{{ route('roadmaps.edit', $roadmap) }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg font-semibold text-xs text-slate-700 uppercase tracking-widest hover:bg-slate-50 transition shadow-sm">
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Roadmap Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="group bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300 hover:shadow-2xl overflow-hidden relative">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>
                    <div class="relative z-10">
                        <div class="text-xs font-bold text-indigo-100 uppercase tracking-wider mb-3">Progress</div>
                        <div class="flex items-end gap-2">
                            <div class="text-4xl font-black text-white">
                                {{ number_format($roadmap->progress_percentage, 0) }}<span class="text-xl">%</span></div>
                        </div>
                        <div class="w-full bg-white bg-opacity-20 rounded-full h-2 mt-4 overflow-hidden">
                            <div class="bg-white h-2 rounded-full transition-all duration-1000 ease-out"
                                style="width: {{ $roadmap->progress_percentage }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="group bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300 hover:shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>
                    <div class="relative z-10">
                        <div class="text-xs font-bold text-green-100 uppercase tracking-wider mb-3">Topics</div>
                        <div class="text-4xl font-black text-white">{{ $roadmap->completed_topics }}<span
                                class="text-white text-opacity-60 text-2xl font-bold">/{{ $roadmap->total_topics }}</span></div>
                    </div>
                </div>
                <div class="group bg-gradient-to-br from-blue-500 to-cyan-600 rounded-3xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300 hover:shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>
                    <div class="relative z-10">
                        <div class="text-xs font-bold text-blue-100 uppercase tracking-wider mb-3">Status</div>
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-white {{ $roadmap->status === 'completed' ? 'text-green-700' : ($roadmap->status === 'in_progress' ? 'text-blue-700' : 'text-gray-700') }} shadow-lg">
                            {{ ucfirst(str_replace('_', ' ', $roadmap->status)) }}
                        </span>
                    </div>
                </div>
                <div class="group bg-gradient-to-br from-orange-500 to-red-600 rounded-3xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300 hover:shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>
                    <div class="relative z-10">
                        <div class="text-xs font-bold text-orange-100 uppercase tracking-wider mb-3">Started</div>
                        <div class="text-xl font-bold text-white">
                            @if ($roadmap->start_date)
                                {{ $roadmap->start_date->format('M d, Y') }}
                            @else
                                <span class="text-white text-opacity-80 font-normal text-base">Not started</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Topics List -->
            <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 overflow-hidden">
                <div class="p-8 border-b-2 border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50 flex justify-between items-center">
                    <h3 class="font-black text-2xl text-gray-900">Curriculum</h3>
                    <span class="text-sm font-bold text-indigo-600 bg-white px-4 py-2 rounded-full shadow-md">{{ $roadmap->topics->count() }} modules</span>
                </div>

                @if ($roadmap->topics->isEmpty())
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-medium text-slate-900">No topics yet</h4>
                        <p class="text-slate-500 mb-6">Add your first topic to start building this roadmap.</p>
                        <a href="{{ route('topics.create', ['roadmap_id' => $roadmap->id]) }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            Add First Topic
                        </a>
                    </div>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach ($roadmap->topics()->whereNull('parent_id')->orderBy('order')->get() as $topic)
                            <div class="p-6 hover:bg-gradient-to-r hover:from-indigo-50/50 hover:to-purple-50/50 transition-all duration-300 group border-l-4 border-transparent hover:border-indigo-500 hover:shadow-lg">
                                <div class="flex items-start gap-4">
                                    <!-- Status Icon -->
                                    <div class="flex-shrink-0 mt-1">
                                        @if ($topic->status === 'completed')
                                            <div
                                                class="w-10 h-10 rounded-full bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center text-green-600 shadow-md ring-2 ring-green-200/50">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        @elseif($topic->status === 'in_progress')
                                            <div
                                                class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-100 to-cyan-100 flex items-center justify-center text-blue-600 shadow-md ring-2 ring-blue-200/50 animate-pulse">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        @else
                                            <div
                                                class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-100 to-gray-100 flex items-center justify-center text-slate-500 shadow-md ring-2 ring-slate-200/50">
                                                <span class="font-bold text-xs">{{ $loop->iteration }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4
                                                class="text-xl font-black text-slate-900 group-hover:text-indigo-600 transition-colors">
                                                <a href="{{ route('topics.show', $topic) }}">
                                                    {{ $topic->title }}
                                                </a>
                                            </h4>
                                            <div
                                                class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <a href="{{ route('topics.show', $topic) }}"
                                                    class="p-1 text-slate-400 hover:text-indigo-600 rounded">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('topics.edit', $topic) }}"
                                                    class="p-1 text-slate-400 hover:text-indigo-600 rounded">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>

                                        @if ($topic->description)
                                            <p class="text-sm text-slate-600 mb-3">
                                                {{ Str::limit($topic->description, 150) }}</p>
                                        @endif

                                        <div class="flex items-center gap-4 text-xs font-bold text-slate-600">
                                            @if ($topic->estimated_hours)
                                                <span class="flex items-center gap-1 bg-gradient-to-r from-blue-50 to-cyan-50 px-3 py-1.5 rounded-full"><svg class="w-4 h-4"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg> {{ $topic->estimated_hours }}h</span>
                                            @endif
                                            <span class="flex items-center gap-1 bg-gradient-to-r from-purple-50 to-pink-50 px-3 py-1.5 rounded-full"><svg class="w-4 h-4" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg> {{ $topic->resources->count() }} resources</span>
                                            @if ($topic->children->count() > 0)
                                                <span class="flex items-center gap-1 bg-gradient-to-r from-green-50 to-emerald-50 px-3 py-1.5 rounded-full"><svg class="w-4 h-4"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                                    </svg> {{ $topic->children->count() }} sub-modules</span>
                                            @endif
                                        </div>
                                        <!-- Topic Progress -->
                                        @if ($topic->progress && $topic->progress->getProgressPercentage() > 0)
                                            <div class="mt-4 max-w-md">
                                                <div class="flex items-center justify-between text-xs font-bold text-slate-600 mb-1">
                                                    <span>Progress</span>
                                                    <span class="text-indigo-600">{{ $topic->progress->getProgressPercentage() }}%</span>
                                                </div>
                                                <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden shadow-inner">
                                                    <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 h-2 rounded-full transition-all duration-1000 ease-out"
                                                        style="width: {{ $topic->progress->getProgressPercentage() }}%">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Subtopics Preview -->
                                @if ($topic->children->count() > 0)
                                    <div class="mt-4 pl-12 border-l-2 border-gradient-to-b from-indigo-200 to-purple-200 ml-4 space-y-2">
                                        @foreach ($topic->children()->orderBy('order')->take(3)->get() as $subtopic)
                                            <a href="{{ route('topics.show', $subtopic) }}"
                                                class="block p-3 rounded-xl hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 text-sm font-semibold text-slate-700 hover:text-indigo-700 transition-all hover:shadow-md hover:pl-4">
                                                <span class="mr-2 text-indigo-400 text-lg">›</span> {{ $subtopic->title }}
                                            </a>
                                        @endforeach
                                        @if ($topic->children->count() > 3)
                                            <a href="{{ route('topics.show', $topic) }}"
                                                class="block p-2 text-xs font-semibold text-indigo-600 hover:underline">
                                                + {{ $topic->children->count() - 3 }} more sub-modules
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Certificate Section -->
            @if ($roadmap->status === 'completed')
                <div
                    class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-8 border border-green-100 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <h3 class="text-2xl font-bold text-green-900 mb-2">🎉 Congratulations!</h3>
                        <p class="text-green-700">You have completed all topics in this roadmap. Your certificate is
                            ready.</p>
                    </div>
                    <div>
                        @if ($roadmap->certificate)
                            <a href="{{ route('certificates.show', $roadmap->certificate) }}"
                                class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl shadow-lg hover:shadow-green-500/30 transition transform hover:-translate-y-1">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                View Certificate
                            </a>
                        @else
                            <form action="{{ route('certificates.generate', $roadmap) }}" method="POST"
                                class="inline">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl shadow-lg hover:shadow-green-500/30 transition transform hover:-translate-y-1">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Claim Certificate
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
