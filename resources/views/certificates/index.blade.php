<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('My Certificates') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($certificates->isEmpty())
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <h3 class="mt-2 text-lg font-medium text-slate-900">No certificates earned yet</h3>
                    <p class="mt-1 text-slate-500">Complete roadmaps to earn your first certificate.</p>
                    <div class="mt-6">
                        <a href="{{ route('roadmaps.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            Explore Roadmaps
                        </a>
                    </div>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($certificates as $certificate)
                        <div
                            class="relative bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-200 overflow-hidden group">
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
                                        class="flex-1 text-center bg-white border border-slate-200 hover:border-indigo-600 hover:text-indigo-600 text-slate-700 font-bold py-2.5 px-4 rounded-lg text-sm transition shadow-sm">
                                        View
                                    </a>
                                    <button
                                        onclick="window.open('{{ route('certificates.show', $certificate) }}').print()"
                                        class="flex-1 text-center bg-slate-900 hover:bg-slate-800 text-white font-bold py-2.5 px-4 rounded-lg text-sm transition shadow-lg hover:shadow-xl">
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
</x-app-layout>
