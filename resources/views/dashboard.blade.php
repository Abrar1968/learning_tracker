<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="text-sm text-gray-600">
                <span class="font-medium">Welcome back!</span> {{ auth()->user()->name }}
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">
                <!-- Total Roadmaps -->
                <div class="group bg-gradient-to-br from-indigo-500 to-indigo-600 overflow-hidden shadow-lg rounded-xl transform hover:scale-105 transition-all duration-300 hover:shadow-2xl">
                    <div class="p-6 relative">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full transform group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex-shrink-0">
                                    <div class="p-3 bg-white bg-opacity-20 rounded-lg backdrop-blur-sm">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-3xl font-bold text-white animate-pulse">{{ $stats['total_roadmaps'] }}</p>
                                </div>
                            </div>
                            <p class="text-sm font-medium text-indigo-100">Total Roadmaps</p>
                        </div>
                    </div>
                </div>

                <!-- Active Roadmaps -->
                <div class="group bg-gradient-to-br from-green-500 to-emerald-600 overflow-hidden shadow-lg rounded-xl transform hover:scale-105 transition-all duration-300 hover:shadow-2xl">
                    <div class="p-6 relative">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full transform group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex-shrink-0">
                                    <div class="p-3 bg-white bg-opacity-20 rounded-lg backdrop-blur-sm">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-3xl font-bold text-white animate-pulse">{{ $stats['active_roadmaps'] }}</p>
                                </div>
                            </div>
                            <p class="text-sm font-medium text-green-100">Active Roadmaps</p>
                        </div>
                    </div>
                </div>

                <!-- Completed Roadmaps -->
                <div class="group bg-gradient-to-br from-purple-500 to-purple-600 overflow-hidden shadow-lg rounded-xl transform hover:scale-105 transition-all duration-300 hover:shadow-2xl">
                    <div class="p-6 relative">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full transform group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex-shrink-0">
                                    <div class="p-3 bg-white bg-opacity-20 rounded-lg backdrop-blur-sm">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-3xl font-bold text-white animate-pulse">{{ $stats['completed_roadmaps'] }}</p>
                                </div>
                            </div>
                            <p class="text-sm font-medium text-purple-100">Completed</p>
                        </div>
                    </div>
                </div>

                <!-- Certificates Earned -->
                <div class="group bg-gradient-to-br from-yellow-500 to-orange-500 overflow-hidden shadow-lg rounded-xl transform hover:scale-105 transition-all duration-300 hover:shadow-2xl">
                    <div class="p-6 relative">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full transform group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex-shrink-0">
                                    <div class="p-3 bg-white bg-opacity-20 rounded-lg backdrop-blur-sm">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-3xl font-bold text-white animate-pulse">{{ $stats['certificates_earned'] }}</p>
                                </div>
                            </div>
                            <p class="text-sm font-medium text-yellow-100">Certificates</p>
                        </div>
                    </div>
                </div>

                <!-- Time Spent -->
                <div class="group bg-gradient-to-br from-red-500 to-pink-600 overflow-hidden shadow-lg rounded-xl transform hover:scale-105 transition-all duration-300 hover:shadow-2xl">
                    <div class="p-6 relative">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full transform group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex-shrink-0">
                                    <div class="p-3 bg-white bg-opacity-20 rounded-lg backdrop-blur-sm">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-3xl font-bold text-white animate-pulse">{{ $stats['time_spent_hours'] }}</p>
                                </div>
                            </div>
                            <p class="text-sm font-medium text-red-100">Hours Invested</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Roadmaps and Activities -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Roadmaps -->
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl transform hover:scale-[1.02] transition-all duration-300">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-white">Recent Roadmaps</h3>
                            </div>
                            <a href="{{ route('roadmaps.index') }}" class="text-sm text-white hover:text-indigo-100 transition-colors font-medium flex items-center space-x-1">
                                <span>View all</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="p-6">
                        @if($recentRoadmaps->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentRoadmaps as $roadmap)
                                    <div class="group relative bg-gradient-to-r from-gray-50 to-gray-100 hover:from-indigo-50 hover:to-purple-50 border-l-4 border-indigo-500 rounded-r-lg p-4 transform hover:translate-x-2 transition-all duration-300 shadow-sm hover:shadow-md">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <a href="{{ route('roadmaps.show', $roadmap) }}" class="text-base font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">
                                                    {{ $roadmap->title }}
                                                </a>
                                                <div class="mt-2 flex items-center text-sm text-gray-600">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                                        {{ $roadmap->status === 'completed' ? 'bg-green-100 text-green-800' : ($roadmap->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                                        {{ ucfirst(str_replace('_', ' ', $roadmap->status)) }}
                                                    </span>
                                                    <span class="mx-2">•</span>
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                                    </svg>
                                                    <span class="font-medium">{{ $roadmap->topics_count }} topics</span>
                                                </div>
                                            </div>
                                            <div class="ml-6 text-right">
                                                <div class="text-lg font-bold text-indigo-600">{{ number_format($roadmap->overall_progress_percentage, 0) }}%</div>
                                                <div class="mt-2 w-20 bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2.5 rounded-full transition-all duration-1000 ease-out" style="width: {{ $roadmap->overall_progress_percentage }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 mb-4">
                                    <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No roadmaps yet</h3>
                                <p class="text-sm text-gray-500 mb-6">Get started by creating your first learning roadmap.</p>
                                <a href="{{ route('roadmaps.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-lg text-sm font-medium rounded-lg text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Create Your First Roadmap
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl transform hover:scale-[1.02] transition-all duration-300">
                    <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-white">Recent Activity</h3>
                            </div>
                            <a href="{{ route('activities.index') }}" class="text-sm text-white hover:text-green-100 transition-colors font-medium flex items-center space-x-1">
                                <span>View all</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="p-6">
                        @if($recentActivities->count() > 0)
                            <div class="flow-root">
                                <ul class="-mb-8">
                                    @foreach($recentActivities as $activity)
                                        <li class="group">
                                            <div class="relative pb-8">
                                                @if(!$loop->last)
                                                    <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gradient-to-b from-indigo-200 to-purple-200" aria-hidden="true"></span>
                                                @endif
                                                <div class="relative flex space-x-4 items-start hover:bg-gray-50 rounded-lg p-2 -m-2 transition-colors duration-200">
                                                    <div>
                                                        <span class="h-10 w-10 rounded-full flex items-center justify-center ring-4 ring-white shadow-lg
                                                            {{ str_contains($activity->action_name, 'created') ? 'bg-gradient-to-br from-indigo-500 to-indigo-600' : (str_contains($activity->action_name, 'completed') ? 'bg-gradient-to-br from-green-500 to-green-600' : (str_contains($activity->action_name, 'certificate') ? 'bg-gradient-to-br from-yellow-500 to-orange-500' : 'bg-gradient-to-br from-gray-400 to-gray-500')) }} transform group-hover:scale-110 transition-transform duration-200">
                                                            @if(str_contains($activity->action_name, 'created'))
                                                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                                </svg>
                                                            @elseif(str_contains($activity->action_name, 'completed'))
                                                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                                </svg>
                                                            @elseif(str_contains($activity->action_name, 'certificate'))
                                                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                                                </svg>
                                                            @else
                                                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                                </svg>
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1">
                                                        <div class="flex-1">
                                                            <p class="text-sm font-medium text-gray-900">{{ $activity->description }}</p>
                                                        </div>
                                                        <div class="whitespace-nowrap text-right">
                                                            <time class="text-xs text-gray-500 font-medium">{{ $activity->created_at->diffForHumans() }}</time>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4">
                                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No activity yet</h3>
                                <p class="text-sm text-gray-500">Start learning to see your progress tracked here!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="mr-3">Quick Actions</span>
                    <div class="flex-1 h-0.5 bg-gradient-to-r from-gray-300 to-transparent"></div>
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <a href="{{ route('roadmaps.create') }}" class="group relative bg-white overflow-hidden shadow-lg rounded-2xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative p-8 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-100 to-purple-100 group-hover:from-white group-hover:to-white mb-4 transform group-hover:rotate-12 transition-all duration-300 shadow-lg">
                                <svg class="h-8 w-8 text-indigo-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <h4 class="text-base font-bold text-gray-900 group-hover:text-white transition-colors mb-2">New Roadmap</h4>
                            <p class="text-sm text-gray-500 group-hover:text-indigo-100 transition-colors">Create learning path</p>
                        </div>
                    </a>

                    <a href="{{ route('roadmaps.index') }}" class="group relative bg-white overflow-hidden shadow-lg rounded-2xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                        <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative p-8 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-green-100 to-emerald-100 group-hover:from-white group-hover:to-white mb-4 transform group-hover:rotate-12 transition-all duration-300 shadow-lg">
                                <svg class="h-8 w-8 text-green-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h4 class="text-base font-bold text-gray-900 group-hover:text-white transition-colors mb-2">My Roadmaps</h4>
                            <p class="text-sm text-gray-500 group-hover:text-green-100 transition-colors">View all paths</p>
                        </div>
                    </a>

                    <a href="{{ route('certificates.index') }}" class="group relative bg-white overflow-hidden shadow-lg rounded-2xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                        <div class="absolute inset-0 bg-gradient-to-br from-yellow-500 to-orange-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative p-8 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-yellow-100 to-orange-100 group-hover:from-white group-hover:to-white mb-4 transform group-hover:rotate-12 transition-all duration-300 shadow-lg">
                                <svg class="h-8 w-8 text-yellow-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                            <h4 class="text-base font-bold text-gray-900 group-hover:text-white transition-colors mb-2">Certificates</h4>
                            <p class="text-sm text-gray-500 group-hover:text-yellow-100 transition-colors">View achievements</p>
                        </div>
                    </a>

                    <a href="{{ route('activities.index') }}" class="group relative bg-white overflow-hidden shadow-lg rounded-2xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-pink-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative p-8 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-100 to-pink-100 group-hover:from-white group-hover:to-white mb-4 transform group-hover:rotate-12 transition-all duration-300 shadow-lg">
                                <svg class="h-8 w-8 text-purple-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h4 class="text-base font-bold text-gray-900 group-hover:text-white transition-colors mb-2">Activity Feed</h4>
                            <p class="text-sm text-gray-500 group-hover:text-purple-100 transition-colors">Track progress</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
