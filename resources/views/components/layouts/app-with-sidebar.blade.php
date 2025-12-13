@props([])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' || (localStorage.getItem('theme') === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches), sidebarOpen: true, sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }"
      x-init="$watch('darkMode', val => document.documentElement.classList.toggle('dark', val)); $watch('sidebarCollapsed', val => localStorage.setItem('sidebarCollapsed', val))"
      :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @auth
        <meta name="user-id" content="{{ auth()->id() }}">
        @endauth

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Prevent FOUC for dark mode -->
        <script>
            (function() {
                const theme = localStorage.getItem('theme') || 'system';
                if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }

            /* Smooth sidebar transitions */
            .sidebar-transition {
                transition: width 0.3s ease-in-out, transform 0.3s ease-in-out;
            }

            /* Custom scrollbar */
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: rgba(156, 163, 175, 0.4);
                border-radius: 3px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: rgba(156, 163, 175, 0.6);
            }
            .dark .custom-scrollbar::-webkit-scrollbar-thumb {
                background: rgba(75, 85, 99, 0.6);
            }

            /* Glassmorphism effect */
            .glass {
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-slate-50 dark:bg-dark-900 text-gray-900 dark:text-gray-100">
        <div class="min-h-screen flex">
            <!-- Sidebar -->
            @include('components.layouts.sidebar')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-h-screen transition-all duration-300"
                 :class="sidebarCollapsed ? 'lg:ml-20' : 'lg:ml-64'">

                <!-- Top Header Bar -->
                <header class="sticky top-0 z-40 bg-white/80 dark:bg-dark-800/80 glass border-b border-gray-200 dark:border-dark-700">
                    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                        <!-- Mobile menu button -->
                        <button @click="sidebarOpen = !sidebarOpen"
                                class="lg:hidden p-2 rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-dark-700 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        <!-- Page Title -->
                        @isset($header)
                            <div class="flex-1 ml-4 lg:ml-0">
                                {{ $header }}
                            </div>
                        @endisset

                        <!-- Search Button Only -->
                        <div class="flex items-center">
                            <button @click="$dispatch('open-global-search')"
                                    class="p-2 rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-dark-700 transition-colors"
                                    title="Search (⌘K)">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </header>

                <!-- Flash Messages -->
                <div class="px-4 sm:px-6 lg:px-8 mt-4">
                    @include('components.flash-messages')
                </div>

                <!-- Page Content -->
                <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6">
                    {{ $slot }}
                </main>

                <!-- Footer -->
                <footer class="mt-auto py-4 px-4 sm:px-6 lg:px-8 border-t border-gray-200 dark:border-dark-700">
                    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                        <p>&copy; {{ date('Y') }} Learning Tracker. All rights reserved.</p>
                        <p class="hidden sm:block">Press <kbd class="px-1.5 py-0.5 bg-gray-100 dark:bg-dark-700 rounded text-xs">?</kbd> for keyboard shortcuts</p>
                    </div>
                </footer>
            </div>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen"
             x-cloak
             @click="sidebarOpen = false"
             class="fixed inset-0 z-40 bg-black/50 lg:hidden"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        <!-- Global Search Component -->
        <x-global-search />

        <!-- Keyboard Shortcuts Help -->
        <x-keyboard-shortcuts-help />

        <!-- Toast Notifications -->
        <x-toast-container />
    </body>
</html>
