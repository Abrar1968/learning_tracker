<!-- Desktop Sidebar -->
<aside class="hidden lg:flex lg:flex-col sidebar-transition fixed left-0 top-0 bottom-0 z-40 bg-white dark:bg-dark-800 border-r border-gray-200 dark:border-dark-700"
       :class="sidebarCollapsed ? 'w-20' : 'w-64'">

    <!-- Logo -->
    <div class="flex items-center h-16 px-4 border-b border-gray-200 dark:border-dark-700">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group" :class="sidebarCollapsed ? 'justify-center' : ''">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg group-hover:scale-105 transition-transform">
                LT
            </div>
            <span x-show="!sidebarCollapsed" x-transition class="font-bold text-gray-900 dark:text-white text-lg">
                Learning Tracker
            </span>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto custom-scrollbar py-4 px-3 space-y-1">
        <!-- Main Navigation -->
        <div class="space-y-1">
            <p x-show="!sidebarCollapsed" class="px-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Main</p>

            <a href="{{ route('dashboard') }}"
               class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-all duration-200 group
                      {{ request()->routeIs('dashboard')
                         ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-500/30'
                         : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700' }}"
               :class="sidebarCollapsed ? 'justify-center' : ''"
               title="Dashboard">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span x-show="!sidebarCollapsed" x-transition class="ml-3">Dashboard</span>
            </a>

            <a href="{{ route('roadmaps.index') }}"
               class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-all duration-200 group
                      {{ request()->routeIs('roadmaps.*')
                         ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-500/30'
                         : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700' }}"
               :class="sidebarCollapsed ? 'justify-center' : ''"
               title="Roadmaps">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
                <span x-show="!sidebarCollapsed" x-transition class="ml-3">Roadmaps</span>
            </a>

            <a href="{{ route('activities.index') }}"
               class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-all duration-200 group
                      {{ request()->routeIs('activities.*')
                         ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-500/30'
                         : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700' }}"
               :class="sidebarCollapsed ? 'justify-center' : ''"
               title="Activity">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span x-show="!sidebarCollapsed" x-transition class="ml-3">Activity</span>
            </a>

            <a href="{{ route('certificates.index') }}"
               class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-all duration-200 group
                      {{ request()->routeIs('certificates.*')
                         ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-500/30'
                         : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700' }}"
               :class="sidebarCollapsed ? 'justify-center' : ''"
               title="Certificates">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
                <span x-show="!sidebarCollapsed" x-transition class="ml-3">Certificates</span>
            </a>
        </div>

        <!-- Productivity Section -->
        <div class="pt-6 space-y-1">
            <p x-show="!sidebarCollapsed" class="px-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Productivity</p>

            <a href="{{ route('focus.index') }}"
               class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-all duration-200 group
                      {{ request()->routeIs('focus.*')
                         ? 'bg-gradient-to-r from-orange-500 to-red-500 text-white shadow-lg shadow-orange-500/30'
                         : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700' }}"
               :class="sidebarCollapsed ? 'justify-center' : ''"
               title="Focus Timer">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span x-show="!sidebarCollapsed" x-transition class="ml-3">Focus Timer</span>
            </a>

            <a href="{{ route('challenges.index') }}"
               class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-all duration-200 group
                      {{ request()->routeIs('challenges.*')
                         ? 'bg-gradient-to-r from-amber-500 to-yellow-500 text-white shadow-lg shadow-amber-500/30'
                         : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700' }}"
               :class="sidebarCollapsed ? 'justify-center' : ''"
               title="Daily Challenges">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <span x-show="!sidebarCollapsed" x-transition class="ml-3">Challenges</span>
                @php
                    $pendingChallenges = \App\Models\DailyChallenge::where('user_id', auth()->id())
                        ->whereDate('challenge_date', today())
                        ->where('is_completed', false)
                        ->count();
                @endphp
                @if($pendingChallenges > 0)
                    <span x-show="!sidebarCollapsed" class="ml-auto px-2 py-0.5 text-xs font-bold rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                        {{ $pendingChallenges }}
                    </span>
                @endif
            </a>

            <a href="{{ route('reviews.index') }}"
               class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-all duration-200 group
                      {{ request()->routeIs('reviews.*')
                         ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg shadow-green-500/30'
                         : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700' }}"
               :class="sidebarCollapsed ? 'justify-center' : ''"
               title="Spaced Repetition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
                <span x-show="!sidebarCollapsed" x-transition class="ml-3">Reviews</span>
                @php
                    $dueReviewsCount = \App\Models\ReviewSchedule::where('user_id', auth()->id())
                        ->where('next_review_date', '<=', now())
                        ->where('is_active', true)
                        ->count();
                @endphp
                @if($dueReviewsCount > 0)
                    <span x-show="!sidebarCollapsed" class="ml-auto px-2 py-0.5 text-xs font-bold rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                        {{ $dueReviewsCount }}
                    </span>
                @endif
            </a>
        </div>

        <!-- Resources Section -->
        <div class="pt-6 space-y-1">
            <p x-show="!sidebarCollapsed" class="px-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Resources</p>

            <a href="{{ route('templates.index') }}"
               class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-all duration-200 group
                      {{ request()->routeIs('templates.*')
                         ? 'bg-gradient-to-r from-violet-500 to-purple-500 text-white shadow-lg shadow-violet-500/30'
                         : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700' }}"
               :class="sidebarCollapsed ? 'justify-center' : ''"
               title="Templates">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                </svg>
                <span x-show="!sidebarCollapsed" x-transition class="ml-3">Templates</span>
            </a>

            <a href="{{ route('bookmarks.index') }}"
               class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-all duration-200 group
                      {{ request()->routeIs('bookmarks.*')
                         ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg shadow-blue-500/30'
                         : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700' }}"
               :class="sidebarCollapsed ? 'justify-center' : ''"
               title="Bookmarks">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                </svg>
                <span x-show="!sidebarCollapsed" x-transition class="ml-3">Bookmarks</span>
            </a>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="border-t border-gray-200 dark:border-dark-700">
        <!-- Dark Mode & Settings -->
        <div class="p-3 space-y-2" x-show="!sidebarCollapsed" x-transition>
            <button @click="darkMode = !darkMode"
                    class="w-full flex items-center px-3 py-2 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700 transition-colors">
                <svg x-show="!darkMode" class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
                <svg x-show="darkMode" x-cloak class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span class="ml-3">Dark Mode</span>
            </button>
        </div>

        <!-- Collapsed icons -->
        <div class="p-3 space-y-2" x-show="sidebarCollapsed" x-transition>
            <button @click="darkMode = !darkMode"
                    class="w-full flex items-center justify-center p-2 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700 transition-colors"
                    title="Toggle dark mode">
                <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
                <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </button>
        </div>

        <!-- User Profile Section -->
        <div class="p-3 border-t border-gray-200 dark:border-dark-700" x-data="{ userOpen: false }">
            <div class="relative">
                <button @click="userOpen = !userOpen"
                        class="w-full flex items-center px-3 py-2 rounded-xl hover:bg-gray-100 dark:hover:bg-dark-700 transition-colors"
                        :class="sidebarCollapsed ? 'justify-center' : ''">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div x-show="!sidebarCollapsed" x-transition class="ml-3 flex-1 text-left">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                    </div>
                    <svg x-show="!sidebarCollapsed" class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- User Dropdown -->
                <div x-show="userOpen && !sidebarCollapsed"
                     @click.away="userOpen = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute bottom-full left-3 right-3 mb-2 rounded-xl bg-white dark:bg-dark-800 shadow-xl ring-1 ring-black/5 dark:ring-white/10 py-1 z-50">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-dark-700">
                        Profile Settings
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Toggle -->
        <div class="p-3 border-t border-gray-200 dark:border-dark-700">
            <button @click="sidebarCollapsed = !sidebarCollapsed"
                    class="w-full flex items-center justify-center px-3 py-2 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-dark-700 transition-colors"
                    title="Toggle sidebar">
                <svg x-show="!sidebarCollapsed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                </svg>
                <svg x-show="sidebarCollapsed" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>
</aside>

<!-- Mobile Sidebar -->
<aside x-show="sidebarOpen"
       x-cloak
       class="lg:hidden fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-dark-800 shadow-2xl"
       x-transition:enter="transform transition-transform duration-300"
       x-transition:enter-start="-translate-x-full"
       x-transition:enter-end="translate-x-0"
       x-transition:leave="transform transition-transform duration-300"
       x-transition:leave-start="translate-x-0"
       x-transition:leave-end="-translate-x-full">

    <!-- Mobile Header -->
    <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 dark:border-dark-700">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                LT
            </div>
            <span class="font-bold text-gray-900 dark:text-white text-lg">Learning Tracker</span>
        </a>
        <button @click="sidebarOpen = false" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-dark-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Mobile Navigation - same structure as desktop but always expanded -->
    <nav class="flex-1 overflow-y-auto custom-scrollbar py-4 px-3 space-y-1">
        <!-- Main Navigation -->
        <div class="space-y-1">
            <p class="px-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Main</p>

            <a href="{{ route('dashboard') }}" @click="sidebarOpen = false"
               class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-all duration-200
                      {{ request()->routeIs('dashboard')
                         ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg'
                         : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="ml-3">Dashboard</span>
            </a>

            <a href="{{ route('roadmaps.index') }}" @click="sidebarOpen = false"
               class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-all duration-200
                      {{ request()->routeIs('roadmaps.*')
                         ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg'
                         : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
                <span class="ml-3">Roadmaps</span>
            </a>

            <a href="{{ route('activities.index') }}" @click="sidebarOpen = false"
               class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-all duration-200
                      {{ request()->routeIs('activities.*')
                         ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg'
                         : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="ml-3">Activity</span>
            </a>

            <a href="{{ route('certificates.index') }}" @click="sidebarOpen = false"
               class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-all duration-200
                      {{ request()->routeIs('certificates.*')
                         ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg'
                         : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
                <span class="ml-3">Certificates</span>
            </a>
        </div>

        <!-- Productivity Section -->
        <div class="pt-6 space-y-1">
            <p class="px-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Productivity</p>

            <a href="{{ route('focus.index') }}" @click="sidebarOpen = false"
               class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-all duration-200
                      {{ request()->routeIs('focus.*')
                         ? 'bg-gradient-to-r from-orange-500 to-red-500 text-white shadow-lg'
                         : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="ml-3">Focus Timer</span>
            </a>

            <a href="{{ route('challenges.index') }}" @click="sidebarOpen = false"
               class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-all duration-200
                      {{ request()->routeIs('challenges.*')
                         ? 'bg-gradient-to-r from-amber-500 to-yellow-500 text-white shadow-lg'
                         : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <span class="ml-3">Challenges</span>
            </a>

            <a href="{{ route('reviews.index') }}" @click="sidebarOpen = false"
               class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-all duration-200
                      {{ request()->routeIs('reviews.*')
                         ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg'
                         : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
                <span class="ml-3">Reviews</span>
            </a>
        </div>

        <!-- Resources Section -->
        <div class="pt-6 space-y-1">
            <p class="px-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Resources</p>

            <a href="{{ route('templates.index') }}" @click="sidebarOpen = false"
               class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-all duration-200
                      {{ request()->routeIs('templates.*')
                         ? 'bg-gradient-to-r from-violet-500 to-purple-500 text-white shadow-lg'
                         : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                </svg>
                <span class="ml-3">Templates</span>
            </a>

            <a href="{{ route('bookmarks.index') }}" @click="sidebarOpen = false"
               class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-all duration-200
                      {{ request()->routeIs('bookmarks.*')
                         ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg'
                         : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                </svg>
                <span class="ml-3">Bookmarks</span>
            </a>
        </div>
    </nav>

    <!-- Mobile User Info -->
    <div class="p-4 border-t border-gray-200 dark:border-dark-700">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
</aside>
