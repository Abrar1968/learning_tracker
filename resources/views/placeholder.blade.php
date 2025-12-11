@extends('layouts.app')

@section('title', 'Coming Soon - Learning Progress Tracker')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col items-center justify-center min-h-[60vh]">
        <div class="bg-white rounded-lg shadow-lg p-12 text-center max-w-2xl">
            <div class="mb-6">
                <svg class="mx-auto h-24 w-24 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Coming Soon</h1>
            <p class="text-lg text-gray-600 mb-8">
                This feature is currently under development and will be available soon.
                We're working hard to bring you an amazing experience!
            </p>
            <a href="{{ route('dashboard') }}" class="btn-primary inline-flex items-center px-6 py-3 rounded-md text-base font-medium text-white">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
