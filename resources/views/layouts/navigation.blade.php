<nav x-data="{ open: false }"
    class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 shadow-xl sticky top-0 z-50 transition-all duration-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 transition transform hover:scale-110 group">
                        <div class="w-12 h-12 bg-white rounded-xl shadow-lg flex items-center justify-center group-hover:rotate-12 transition-transform duration-300">
                            <span class="text-2xl font-black bg-gradient-to-br from-indigo-600 to-purple-600 bg-clip-text text-transparent">LT</span>
                        </div>
                        <span class="text-white font-black text-xl hidden md:block">Learning Tracker</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:ms-10 sm:flex items-center">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 text-white/90 hover:text-white font-semibold rounded-lg hover:bg-white/20 backdrop-blur-sm transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-white/25 text-white' : '' }}">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Dashboard
                        </span>
                    </a>
                    <a href="{{ route('roadmaps.index') }}" class="px-4 py-2 text-white/90 hover:text-white font-semibold rounded-lg hover:bg-white/20 backdrop-blur-sm transition-all duration-200 {{ request()->routeIs('roadmaps.*') ? 'bg-white/25 text-white' : '' }}">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                            Roadmaps
                        </span>
                    </a>
                    <a href="{{ route('activities.index') }}" class="px-4 py-2 text-white/90 hover:text-white font-semibold rounded-lg hover:bg-white/20 backdrop-blur-sm transition-all duration-200 {{ request()->routeIs('activities.*') ? 'bg-white/25 text-white' : '' }}">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Activity
                        </span>
                    </a>
                    <a href="{{ route('certificates.index') }}" class="px-4 py-2 text-white/90 hover:text-white font-semibold rounded-lg hover:bg-white/20 backdrop-blur-sm transition-all duration-200 {{ request()->routeIs('certificates.*') ? 'bg-white/25 text-white' : '' }}">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                            Certificates
                        </span>
                    </a>

                    <!-- More Dropdown -->
                    <div x-data="{ moreOpen: false }" class="relative">
                        <button @click="moreOpen = !moreOpen"
                                class="px-4 py-2 text-white/90 hover:text-white font-semibold rounded-lg hover:bg-white/20 backdrop-blur-sm transition-all duration-200 flex items-center {{ request()->routeIs('focus.*', 'templates.*', 'bookmarks.*', 'challenges.*', 'reviews.*') ? 'bg-white/25 text-white' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                            More
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="moreOpen"
                             @click.away="moreOpen = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute left-0 mt-2 w-56 rounded-xl bg-white dark:bg-dark-800 shadow-xl ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 dark:divide-dark-700 z-50">
                            <div class="py-2">
                                <a href="{{ route('focus.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-dark-700 {{ request()->routeIs('focus.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : '' }}">
                                    <svg class="w-5 h-5 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Focus Timer
                                </a>
                                <a href="{{ route('templates.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-dark-700 {{ request()->routeIs('templates.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : '' }}">
                                    <svg class="w-5 h-5 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                                    </svg>
                                    Templates
                                </a>
                                <a href="{{ route('bookmarks.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-dark-700 {{ request()->routeIs('bookmarks.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : '' }}">
                                    <svg class="w-5 h-5 mr-3 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                    </svg>
                                    Bookmarks
                                </a>
                            </div>
                            <div class="py-2">
                                <a href="{{ route('challenges.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-dark-700 {{ request()->routeIs('challenges.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : '' }}">
                                    <svg class="w-5 h-5 mr-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    Challenges
                                </a>
                                <a href="{{ route('reviews.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-dark-700 {{ request()->routeIs('reviews.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : '' }}">
                                    <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                    Spaced Repetition
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Button -->
            <div class="hidden sm:flex sm:items-center sm:ml-4">
                <button @click="$root.querySelector('[x-data]').dispatchEvent(new CustomEvent('open-global-search'))"
                        class="px-4 py-2 text-white/90 hover:text-white font-semibold rounded-lg hover:bg-white/20 backdrop-blur-sm transition-all duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span class="hidden md:inline">Search</span>
                    <kbd class="hidden lg:inline ml-2 px-2 py-1 text-xs bg-white/20 rounded">⌘K</kbd>
                </button>
            </div>

            <!-- Dark Mode Toggle -->
            <x-dark-mode-toggle class="hidden sm:flex sm:items-center" />

            <!-- Keyboard Shortcuts Button -->
            <button @click="$dispatch('show-keyboard-help')"
                    class="hidden sm:flex p-2 rounded-lg text-white/80 hover:text-white hover:bg-white/20 transition-all duration-200"
                    title="Keyboard shortcuts (?)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
            </button>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm border border-white/30 text-sm leading-4 font-semibold rounded-lg text-white hover:bg-white/30 focus:outline-none focus:ring-2 focus:ring-white/50 transition ease-in-out duration-150">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center mr-2">
                                    <span class="text-indigo-600 font-bold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 focus:text-slate-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden border-t border-slate-100 bg-white">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('roadmaps.index')" :active="request()->routeIs('roadmaps.*')">
                {{ __('Roadmaps') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('activities.index')" :active="request()->routeIs('activities.*')">
                {{ __('Activity') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('certificates.index')" :active="request()->routeIs('certificates.*')">
                {{ __('Certificates') }}
            </x-responsive-nav-link>

            <!-- Additional Features -->
            <div class="border-t border-slate-100 my-2"></div>
            <x-responsive-nav-link :href="route('focus.index')" :active="request()->routeIs('focus.*')">
                {{ __('Focus Timer') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('templates.index')" :active="request()->routeIs('templates.*')">
                {{ __('Templates') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('bookmarks.index')" :active="request()->routeIs('bookmarks.*')">
                {{ __('Bookmarks') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('challenges.index')" :active="request()->routeIs('challenges.*')">
                {{ __('Challenges') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reviews.index')" :active="request()->routeIs('reviews.*')">
                {{ __('Spaced Repetition') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-slate-200 bg-slate-50">
            <div class="px-4">
                <div class="font-medium text-base text-slate-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
