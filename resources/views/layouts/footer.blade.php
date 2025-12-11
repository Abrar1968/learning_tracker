<footer class="bg-gradient-to-br from-slate-900 via-purple-900 to-indigo-900 text-white mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <!-- About Section -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-black text-lg">LT</span>
                    </div>
                    <h3 class="text-xl font-black">Learning Tracker</h3>
                </div>
                <p class="text-gray-300 text-sm leading-relaxed mb-4">
                    Track your learning journey, manage roadmaps, monitor progress, and earn certificates.
                    Built with ❤️ using Laravel 12, Tailwind CSS & Alpine.js.
                </p>
                <div class="flex space-x-4">
                    <span class="px-3 py-1 bg-white/10 rounded-full text-xs font-semibold">Laravel 12</span>
                    <span class="px-3 py-1 bg-white/10 rounded-full text-xs font-semibold">Tailwind CSS</span>
                    <span class="px-3 py-1 bg-white/10 rounded-full text-xs font-semibold">Alpine.js</span>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-bold mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        Dashboard
                    </a></li>
                    <li><a href="{{ route('roadmaps.index') }}" class="text-gray-300 hover:text-white transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        My Roadmaps
                    </a></li>
                    <li><a href="{{ route('activities.index') }}" class="text-gray-300 hover:text-white transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        Activity Log
                    </a></li>
                    <li><a href="{{ route('certificates.index') }}" class="text-gray-300 hover:text-white transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        Certificates
                    </a></li>
                </ul>
            </div>

            <!-- Connect -->
            <div>
                <h4 class="text-lg font-bold mb-4">Connect</h4>
                <ul class="space-y-2">
                    <li><a href="https://github.com/Abrar1968/learning_tracker" target="_blank" rel="noopener" class="text-gray-300 hover:text-white transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                        GitHub
                    </a></li>
                    <li><a href="{{ route('profile.edit') }}" class="text-gray-300 hover:text-white transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profile Settings
                    </a></li>
                </ul>

                <div class="mt-6">
                    <p class="text-gray-400 text-xs mb-2">Powered by</p>
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        <span class="text-gray-300 font-semibold">Laravel Framework</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-white/10 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-sm text-gray-400">
                    © {{ date('Y') }} <span class="font-semibold text-white">Learning Progress Tracker</span>. All rights reserved.
                </div>
                <div class="flex items-center space-x-6 text-sm text-gray-400">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span class="font-semibold">Version 1.0.0</span>
                    </span>
                    <span>•</span>
                    <span>Built with passion</span>
                </div>
            </div>
        </div>
    </div>
</footer>
