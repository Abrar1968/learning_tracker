<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight print:hidden">
            {{ __('Certificate of Completion') }}
        </h2>
    </x-slot>

    <div class="py-12 print:p-0">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 print:max-w-full print:px-0">
            <!-- Certificate Container -->
            <div class="relative bg-white text-slate-900 shadow-2xl overflow-hidden print:shadow-none print:w-full print:h-screen"
                id="certificate">

                <!-- Background Pattern (Subtle Guilloche Effect) -->
                <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
                    style="background-image: radial-gradient(circle at 25px 25px, #334155 2%, transparent 0%), radial-gradient(circle at 75px 75px, #334155 2%, transparent 0%); background-size: 100px 100px;">
                </div>

                <!-- Decorative Border -->
                <div
                    class="absolute inset-6 border-4 border-double border-slate-200 pointer-events-none print:inset-0 print:border-8">
                </div>
                <div class="absolute inset-8 border border-slate-100 pointer-events-none print:inset-4"></div>

                <!-- Corner Accents -->
                <div
                    class="absolute top-6 left-6 w-16 h-16 border-t-4 border-l-4 border-indigo-900/20 rounded-tl-3xl print:top-0 print:left-0">
                </div>
                <div
                    class="absolute top-6 right-6 w-16 h-16 border-t-4 border-r-4 border-indigo-900/20 rounded-tr-3xl print:top-0 print:right-0">
                </div>
                <div
                    class="absolute bottom-6 left-6 w-16 h-16 border-b-4 border-l-4 border-indigo-900/20 rounded-bl-3xl print:bottom-0 print:left-0">
                </div>
                <div
                    class="absolute bottom-6 right-6 w-16 h-16 border-b-4 border-r-4 border-indigo-900/20 rounded-br-3xl print:bottom-0 print:right-0">
                </div>

                <div
                    class="relative p-16 flex flex-col items-center justify-between min-h-[700px] text-center print:h-full print:justify-center">

                    <!-- Header -->
                    <div class="space-y-6">
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-full flex items-center justify-center mx-auto shadow-lg text-white mb-6 print:hidden">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="uppercase tracking-[0.2em] text-sm font-semibold text-slate-500">Learning Tracker
                            Certification</div>
                        <h1 class="text-5xl md:text-6xl font-serif text-slate-900 mb-2 tracking-tight">Certificate of
                            Completion</h1>
                        <div class="w-32 h-1 bg-gradient-to-r from-transparent via-indigo-500 to-transparent mx-auto">
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="py-12 space-y-4">
                        <p class="text-xl text-slate-600 font-light italic">This is to certify that</p>

                        <div class="py-4">
                            <h2
                                class="text-4xl md:text-5xl font-bold text-slate-900 font-serif border-b-2 border-indigo-100 inline-block pb-4 px-12">
                                {{ $certificate->user->name }}
                            </h2>
                        </div>

                        <p class="text-xl text-slate-600 font-light italic pt-4">Resulting from the dedication and hard
                            work<br>has successfully completed the roadmap</p>

                        <div class="py-6">
                            <h3 class="text-3xl font-bold text-indigo-900">
                                {{ $certificate->roadmap->title }}
                            </h3>
                        </div>
                    </div>

                    <!-- Stats / Footer -->
                    <div
                        class="w-full max-w-4xl grid grid-cols-1 md:grid-cols-3 gap-12 text-sm border-t border-slate-100 pt-12 items-end">
                        <div class="text-center md:text-left space-y-1">
                            <p class="text-xs text-slate-400 uppercase tracking-wider">Date Issued</p>
                            <p class="font-semibold text-slate-900 text-lg">
                                {{ $certificate->issue_date->format('F d, Y') }}</p>
                        </div>

                        <div class="text-center">
                            <div class="inline-block p-4 border border-slate-200 rounded-lg bg-slate-50">
                                <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Validation ID</p>
                                <p class="font-mono font-bold text-slate-900">{{ $certificate->certificate_number }}</p>
                            </div>
                        </div>

                        <div class="text-center md:text-right space-y-1">
                            <p class="text-xs text-slate-400 uppercase tracking-wider">Total Effort</p>
                            <p class="font-semibold text-slate-900 text-lg">{{ $certificate->total_hours }} Hours</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 flex justify-center gap-4 print:hidden">
                <button onclick="window.print()"
                    class="inline-flex items-center px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl shadow-lg shadow-slate-200 transition transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Certificate
                </button>
                <a href="{{ route('certificates.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold rounded-xl shadow-sm transition">
                    Back to All
                </a>
            </div>
        </div>
    </div>

    <style>
        @media print {
            @page {
                size: landscape;
                margin: 0;
            }

            body {
                background: white;
            }

            header,
            nav,
            footer,
            .print\:hidden {
                display: none !important;
            }

            .print\:p-0 {
                padding: 0 !important;
            }

            .print\:max-w-full {
                max-width: 100% !important;
            }

            #certificate {
                box-shadow: none !important;
                border: none !important;
                width: 100vw !important;
                height: 100vh !important;
                position: fixed;
                top: 0;
                left: 0;
                margin: 0;
                border-radius: 0;
            }
        }
    </style>
</x-app-layout>
