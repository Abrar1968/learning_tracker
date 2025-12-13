<x-layouts.app-with-sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-3xl text-gray-900 leading-tight">
                    {{ __('My Certificates') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">Your achievements and milestones</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($certificates->isEmpty())
                <div class="relative bg-white rounded-3xl shadow-2xl border-t-4 border-gradient-to-r from-yellow-400 via-orange-500 to-red-500 p-12 text-center overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-50/30 to-orange-50/30"></div>
                    <div class="relative z-10">
                        <div class="w-20 h-20 bg-gradient-to-br from-yellow-100 to-orange-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                            <svg class="h-10 w-10 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <h3 class="mt-2 text-2xl font-black text-slate-900">No certificates earned yet</h3>
                        <p class="mt-1 text-slate-600">Complete roadmaps to earn your first certificate.</p>
                        <div class="mt-6">
                            <a href="{{ route('roadmaps.index') }}"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all shadow-xl hover:shadow-2xl">
                                Explore Roadmaps
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($certificates as $certificate)
                        <div
                            class="relative bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 border border-slate-200 overflow-hidden group transform hover:scale-105 hover:-translate-y-2">
                            <!-- Premium Top Border/Gradient -->
                            <div class="h-2 bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500"></div>

                            <div class="p-8 relative">
                                <!-- Watermark/Background Decoration -->
                                <div
                                    class="absolute -right-6 -top-6 text-slate-50 opacity-50 transform rotate-12 pointer-events-none">
                                    <svg class="h-40 w-40" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>

                                <!-- Certificate Icon -->
                                <div class="relative flex justify-center mb-6">
                                    <div
                                        class="bg-gradient-to-br from-yellow-100 to-yellow-50 rounded-full p-4 shadow-inner ring-4 ring-yellow-50/50">
                                        <svg class="h-10 w-10 text-yellow-600 drop-shadow-sm" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Roadmap Title -->
                                <h3
                                    class="relative text-xl font-bold text-slate-900 text-center mb-1 group-hover:text-indigo-600 transition-colors">
                                    {{ $certificate->roadmap->title }}
                                </h3>
                                <p class="text-xs text-center text-slate-500 uppercase tracking-widest mb-6">Certificate
                                    of Completion</p>

                                <!-- Certificate Details -->
                                <div
                                    class="relative space-y-3 text-sm py-4 border-t border-b border-slate-100 mb-6 bg-slate-50/50 rounded-xl px-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-slate-500">Issued On</span>
                                        <span
                                            class="font-bold text-slate-700">{{ $certificate->issue_date->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-slate-500">Total Hours</span>
                                        <span class="font-bold text-slate-700">{{ $certificate->total_hours }}h</span>
                                    </div>
                                </div>

                                <!-- Certificate Number -->
                                <p class="text-[10px] text-slate-400 text-center mb-6 font-mono">
                                    ID: {{ $certificate->certificate_number }}
                                </p>

                                <!-- Actions -->
                                <div class="relative flex gap-3">
                                    <a href="{{ route('certificates.show', $certificate) }}"
                                        class="flex-1 text-center bg-gradient-to-r from-indigo-50 to-purple-50 border-2 border-indigo-200 hover:border-indigo-600 hover:from-indigo-100 hover:to-purple-100 text-indigo-700 font-bold py-2.5 px-4 rounded-xl text-sm transition-all shadow-md hover:shadow-lg transform hover:scale-105">
                                        View
                                    </a>
                                    <button
                                        onclick="window.open('{{ route('certificates.show', $certificate) }}').print()"
                                        class="flex-1 text-center bg-gradient-to-r from-slate-900 to-slate-800 hover:from-slate-800 hover:to-slate-700 text-white font-bold py-2.5 px-4 rounded-xl text-sm transition-all shadow-xl hover:shadow-2xl transform hover:scale-105">
                                        Print
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $certificates->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app-with-sidebar>
