<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Certificate of Completion
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Certificate Card -->
            <div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 border-8 border-double border-yellow-500 rounded-xl shadow-2xl p-12" id="certificate">
                <!-- Decorative Corner -->
                <div class="relative">
                    <div class="absolute top-0 left-0 w-20 h-20 border-l-4 border-t-4 border-yellow-500 rounded-tl-lg"></div>
                    <div class="absolute top-0 right-0 w-20 h-20 border-r-4 border-t-4 border-yellow-500 rounded-tr-lg"></div>
                    <div class="absolute bottom-0 left-0 w-20 h-20 border-l-4 border-b-4 border-yellow-500 rounded-bl-lg"></div>
                    <div class="absolute bottom-0 right-0 w-20 h-20 border-r-4 border-b-4 border-yellow-500 rounded-br-lg"></div>
                    
                    <!-- Header -->
                    <div class="text-center mb-8 pt-8">
                        <div class="inline-block bg-yellow-400 rounded-full p-6 mb-4">
                            <svg class="h-16 w-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                        <h1 class="text-5xl font-bold text-indigo-900 mb-3" style="font-family: 'Georgia', serif;">
                            Certificate of Completion
                        </h1>
                        <p class="text-gray-600 text-lg">This certifies that</p>
                    </div>

                    <!-- Recipient -->
                    <div class="text-center mb-8">
                        <h2 class="text-4xl font-bold text-indigo-800 mb-6" style="font-family: 'Georgia', serif; border-bottom: 3px solid #EAB308; display: inline-block; padding-bottom: 8px;">
                            {{ $certificate->user->name }}
                        </h2>
                        <p class="text-gray-700 text-xl mt-6">has successfully completed the learning roadmap</p>
                        <h3 class="text-3xl font-semibold text-gray-900 mt-4">
                            {{ $certificate->roadmap->title }}
                        </h3>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-3 gap-8 mb-8 max-w-3xl mx-auto py-6">
                        <div class="text-center border-r border-gray-300">
                            <div class="text-sm text-gray-600 mb-1 uppercase tracking-wide">Completion</div>
                            <div class="text-3xl font-bold text-indigo-600">
                                {{ number_format($certificate->completion_percentage, 0) }}%
                            </div>
                        </div>
                        <div class="text-center border-r border-gray-300">
                            <div class="text-sm text-gray-600 mb-1 uppercase tracking-wide">Total Hours</div>
                            <div class="text-3xl font-bold text-indigo-600">
                                {{ $certificate->total_hours }}
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-sm text-gray-600 mb-1 uppercase tracking-wide">Completed On</div>
                            <div class="text-xl font-semibold text-gray-900">
                                {{ $certificate->issue_date->format('F d, Y') }}
                            </div>
                        </div>
                    </div>

                    <!-- Verification Section -->
                    <div class="border-t-2 border-gray-300 pt-6 text-center pb-8">
                        <div class="mb-3">
                            <span class="text-sm text-gray-600">Certificate Number: </span>
                            <span class="font-mono font-bold text-gray-900 text-lg">{{ $certificate->certificate_number }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="text-sm text-gray-600">Verification Code: </span>
                            <span class="font-mono font-bold text-indigo-600 text-lg">{{ $certificate->verification_code }}</span>
                        </div>
                        <a href="{{ route('certificates.verify', ['code' => $certificate->verification_code]) }}" 
                           target="_blank"
                           class="text-sm text-indigo-600 hover:text-indigo-800 no-print">
                            Verify this certificate online →
                        </a>
                    </div>

                    <!-- Signature Section -->
                    <div class="border-t-2 border-gray-300 pt-6 grid grid-cols-2 gap-12 max-w-2xl mx-auto">
                        <div class="text-center">
                            <div class="border-t-2 border-gray-800 pt-2 mb-2">
                                <p class="font-semibold text-gray-900">{{ config('app.name') }}</p>
                            </div>
                            <p class="text-sm text-gray-600">Learning Platform</p>
                        </div>
                        <div class="text-center">
                            <div class="border-t-2 border-gray-800 pt-2 mb-2">
                                <p class="font-semibold text-gray-900">{{ $certificate->issue_date->format('F d, Y') }}</p>
                            </div>
                            <p class="text-sm text-gray-600">Date of Issue</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions (Hidden when printing) -->
            <div class="mt-6 flex justify-center space-x-4 no-print">
                <button onclick="window.print()" 
                        class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Certificate
                </button>
                <a href="{{ route('roadmaps.show', $certificate->roadmap) }}" 
                   class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold rounded-lg">
                    View Roadmap
                </a>
                <a href="{{ route('certificates.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold rounded-lg">
                    All Certificates
                </a>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #certificate, #certificate * {
                visibility: visible;
            }
            #certificate {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print {
                display: none !important;
            }
            header, nav, footer {
                display: none !important;
            }
        }
        
        @page {
            size: landscape;
            margin: 0.5in;
        }
    </style>
</x-app-layout>
