<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Certificates
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($certificates->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No certificates</h3>
                    <p class="mt-1 text-sm text-gray-500">Complete roadmaps to earn certificates.</p>
                    <div class="mt-6">
                        <a href="{{ route('roadmaps.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            View Roadmaps
                        </a>
                    </div>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($certificates as $certificate)
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 border-2 border-yellow-400 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                            <div class="p-6">
                                <!-- Certificate Icon -->
                                <div class="flex justify-center mb-4">
                                    <div class="bg-yellow-400 rounded-full p-4">
                                        <svg class="h-10 w-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Roadmap Title -->
                                <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">
                                    {{ $certificate->roadmap->title }}
                                </h3>

                                <!-- Certificate Details -->
                                <div class="space-y-2 text-sm mb-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Completed:</span>
                                        <span class="font-medium">{{ $certificate->issue_date->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Progress:</span>
                                        <span class="font-medium">{{ number_format($certificate->completion_percentage, 0) }}%</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Total Hours:</span>
                                        <span class="font-medium">{{ $certificate->total_hours }}h</span>
                                    </div>
                                </div>

                                <!-- Certificate Number -->
                                <div class="border-t border-gray-300 pt-3 mb-4">
                                    <p class="text-xs text-gray-600 text-center">
                                        Certificate #{{ $certificate->certificate_number }}
                                    </p>
                                </div>

                                <!-- Actions -->
                                <div class="flex space-x-2">
                                    <a href="{{ route('certificates.show', $certificate) }}" 
                                       class="flex-1 text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                                        View
                                    </a>
                                    <button onclick="window.open('{{ route('certificates.show', $certificate) }}').print()" 
                                            class="flex-1 text-center bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                        Print
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $certificates->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
