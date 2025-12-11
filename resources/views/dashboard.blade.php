<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
                <!-- Total Roadmaps -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Roadmaps</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_roadmaps'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Roadmaps -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Active</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['active_roadmaps'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completed Roadmaps -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Completed</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['completed_roadmaps'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Certificates Earned -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Certificates</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['certificates_earned'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Time Spent -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Time Spent</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['time_spent_hours'] }}h</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Roadmaps and Activities -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Roadmaps -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Recent Roadmaps</h3>
                            <a href="{{ route('roadmaps.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View all</a>
                        </div>

                        @if($recentRoadmaps->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentRoadmaps as $roadmap)
                                    <div class="border-l-4 border-indigo-500 pl-4 py-2">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <a href="{{ route('roadmaps.show', $roadmap) }}" class="text-base font-medium text-gray-900 hover:text-indigo-600">
                                                    {{ $roadmap->title }}
                                                </a>
                                                <div class="mt-1 flex items-center text-sm text-gray-500">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                        @if($roadmap->status === 'completed') bg-green-100 text-green-800
                                                        @elseif($roadmap->status === 'in_progress') bg-blue-100 text-blue-800
                                                        @else bg-gray-100 text-gray-800
                                                        @endif">
                                                        {{ ucfirst(str_replace('_', ' ', $roadmap->status)) }}
                                                    </span>
                                                    <span class="mx-2">•</span>
                                                    <span>{{ $roadmap->topics_count }} topics</span>
                                                </div>
                                            </div>
                                            <div class="ml-4 text-right">
                                                <div class="text-sm font-medium text-gray-900">{{ number_format($roadmap->overall_progress_percentage, 0) }}%</div>
                                                <div class="mt-1 w-16 bg-gray-200 rounded-full h-2">
                                                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $roadmap->overall_progress_percentage }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No roadmaps yet</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new roadmap.</p>
                                <div class="mt-6">
                                    <a href="{{ route('roadmaps.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        New Roadmap
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
                            <a href="{{ route('activities.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View all</a>
                        </div>

                        @if($recentActivities->count() > 0)
                            <div class="flow-root">
                                <ul class="-mb-8">
                                    @foreach($recentActivities as $activity)
                                        <li>
                                            <div class="relative pb-8">
                                                @if(!$loop->last)
                                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                                @endif
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white
                                                            @if(str_contains($activity->action_name, 'created')) bg-indigo-500
                                                            @elseif(str_contains($activity->action_name, 'completed')) bg-green-500
                                                            @elseif(str_contains($activity->action_name, 'certificate')) bg-yellow-500
                                                            @else bg-gray-400
                                                            @endif">
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
                                                    <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                                        <div>
                                                            <p class="text-sm text-gray-900">{{ $activity->description }}</p>
                                                        </div>
                                                        <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                                            <time>{{ $activity->created_at->diffForHumans() }}</time>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No activity yet</h3>
                                <p class="mt-1 text-sm text-gray-500">Start learning to see your progress here!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <a href="{{ route('roadmaps.create') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                        <div class="p-6 text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-indigo-100 mb-3">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <h4 class="text-sm font-medium text-gray-900">New Roadmap</h4>
                            <p class="mt-1 text-xs text-gray-500">Create learning path</p>
                        </div>
                    </a>

                    <a href="{{ route('roadmaps.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                        <div class="p-6 text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-100 mb-3">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h4 class="text-sm font-medium text-gray-900">My Roadmaps</h4>
                            <p class="mt-1 text-xs text-gray-500">View all paths</p>
                        </div>
                    </a>

                    <a href="{{ route('certificates.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                        <div class="p-6 text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-yellow-100 mb-3">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                            <h4 class="text-sm font-medium text-gray-900">Certificates</h4>
                            <p class="mt-1 text-xs text-gray-500">View achievements</p>
                        </div>
                    </a>

                    <a href="{{ route('activities.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                        <div class="p-6 text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-purple-100 mb-3">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h4 class="text-sm font-medium text-gray-900">Activity Feed</h4>
                            <p class="mt-1 text-xs text-gray-500">Track progress</p>
                        </div>
                    </a>
                </div>
            </div>
    </div>
</div>
@endif
@endsection
