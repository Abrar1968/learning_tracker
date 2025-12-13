<div x-data="{ open: false }"
     @show-keyboard-help.window="open = true"
     @close-modal.window="open = false"
     @keydown.escape.window="open = false">
    
    <!-- Modal Backdrop -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 dark:bg-black/70 z-50"
         @click="open = false">
    </div>
    
    <!-- Modal Content -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         @click.self="open = false">
        
        <div class="bg-white dark:bg-dark-800 rounded-2xl shadow-xl max-w-2xl w-full max-h-[80vh] overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-dark-700 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                    <svg class="w-6 h-6 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                    Keyboard Shortcuts
                </h2>
                <button @click="open = false" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Content -->
            <div class="px-6 py-4 overflow-y-auto max-h-[60vh]">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Navigation -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Navigation</h3>
                        <div class="space-y-2">
                            <x-keyboard-shortcut key="g then h" description="Go to Dashboard" />
                            <x-keyboard-shortcut key="g then r" description="Go to Roadmaps" />
                            <x-keyboard-shortcut key="g then a" description="Go to Activities" />
                            <x-keyboard-shortcut key="g then c" description="Go to Certificates" />
                            <x-keyboard-shortcut key="g then p" description="Go to Profile" />
                        </div>
                    </div>
                    
                    <!-- General -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">General</h3>
                        <div class="space-y-2">
                            <x-keyboard-shortcut key="?" description="Show this help" />
                            <x-keyboard-shortcut key="Esc" description="Close modal / Cancel" />
                            <x-keyboard-shortcut key="⌘ K" description="Open global search" />
                            <x-keyboard-shortcut key="d" description="Toggle dark mode" />
                            <x-keyboard-shortcut key="n" description="New item (context-aware)" />
                        </div>
                    </div>
                    
                    <!-- List Navigation -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">List Navigation</h3>
                        <div class="space-y-2">
                            <x-keyboard-shortcut key="j" description="Move down" />
                            <x-keyboard-shortcut key="k" description="Move up" />
                            <x-keyboard-shortcut key="Enter" description="Open selected item" />
                            <x-keyboard-shortcut key="f" description="Focus page search" />
                        </div>
                    </div>
                    
                    <!-- Focus Timer -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Focus Timer</h3>
                        <div class="space-y-2">
                            <x-keyboard-shortcut key="Space" description="Start/Pause timer" />
                            <x-keyboard-shortcut key="r" description="Reset timer" />
                            <x-keyboard-shortcut key="s" description="Skip break" />
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-3 bg-gray-50 dark:bg-dark-700/50 border-t border-gray-200 dark:border-dark-700">
                <p class="text-sm text-gray-500 dark:text-gray-400 text-center">
                    Press <kbd class="px-2 py-1 text-xs bg-gray-200 dark:bg-dark-600 rounded">?</kbd> anytime to show this help
                </p>
            </div>
        </div>
    </div>
</div>
