@extends('layouts.app')

@section('title', 'Dashboard - Learning Progress Tracker')

@section('content')
<!-- Welcome Header -->
<div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
        <p class="text-primary-100">Track your learning journey and achieve your goals</p>
    </div>
</div>

<!-- Stats Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 mb-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Total Roadmaps -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Roadmaps</dt>
                        <dd class="text-3xl font-semibold text-gray-900">{{ $stats['total_roadmaps'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Active Roadmaps -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Active Roadmaps</dt>
                        <dd class="text-3xl font-semibold text-gray-900">{{ $stats['active_roadmaps'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Completed Roadmaps -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                    <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Completed Roadmaps</dt>
                        <dd class="text-3xl font-semibold text-gray-900">{{ $stats['completed_roadmaps'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Total Resources -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                    <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Resources</dt>
                        <dd class="text-3xl font-semibold text-gray-900">{{ $stats['total_resources'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Resources Completed -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                    <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Resources Completed</dt>
                        <dd class="text-3xl font-semibold text-gray-900">{{ $stats['resources_completed'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Certificates Earned -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-100 rounded-md p-3">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Certificates Earned</dt>
                        <dd class="text-3xl font-semibold text-gray-900">{{ $stats['certificates_earned'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Actions</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('roadmaps.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <h3 class="ml-3 text-lg font-semibold text-gray-900">Create Roadmap</h3>
            </div>
            <p class="text-gray-600">Start a new learning path to organize your journey</p>
        </a>

        <a href="{{ route('resources.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200">
            <div class="flex items-center mb-4">
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <h3 class="ml-3 text-lg font-semibold text-gray-900">Add Resource</h3>
            </div>
            <p class="text-gray-600">Add courses, books, or articles to your collection</p>
        </a>

        <a href="{{ route('certificates.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200">
            <div class="flex items-center mb-4">
                <div class="bg-purple-100 rounded-full p-3">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <h3 class="ml-3 text-lg font-semibold text-gray-900">Upload Certificate</h3>
            </div>
            <p class="text-gray-600">Showcase your achievements and earned certifications</p>
        </a>
    </div>
</div>

<!-- Getting Started -->
@if($stats['total_roadmaps'] === 0)
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
    <div class="bg-blue-50 border-l-4 border-primary-600 p-6 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-lg font-medium text-primary-900">Getting Started</h3>
                <div class="mt-2 text-sm text-primary-800">
                    <p class="mb-2">Welcome to Learning Progress Tracker! Here's how to get started:</p>
                    <ol class="list-decimal list-inside space-y-1 ml-4">
                        <li>Create your first roadmap to organize your learning goals</li>
                        <li>Add resources (courses, books, articles) to your roadmap</li>
                        <li>Track your progress as you complete each resource</li>
                        <li>Upload certificates to showcase your achievements</li>
                    </ol>
                </div>
                <div class="mt-4">
                    <a href="{{ route('roadmaps.index') }}" class="btn-primary inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-white">
                        Create Your First Roadmap
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
