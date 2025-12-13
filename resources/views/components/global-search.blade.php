<div x-data="{
    open: false,
    query: '',
    results: { roadmaps: [], topics: [], resources: [] },
    loading: false,

    async search() {
        if (this.query.length < 2) {
            this.results = { roadmaps: [], topics: [], resources: [] };
            return;
        }

        this.loading = true;
        try {
            const response = await fetch(`/search?q=${encodeURIComponent(this.query)}`, {
                headers: { 'Accept': 'application/json' }
            });
            this.results = await response.json();
        } catch (error) {
            console.error('Search error:', error);
        } finally {
            this.loading = false;
        }
    }
}"
@keydown.window.ctrl.k.prevent="open = true"
@keydown.window.cmd.k.prevent="open = true"
@keydown.escape.window="open = false"
@open-global-search.window="open = true"
x-init="$watch('open', value => { if (value) { $nextTick(() => $refs.searchInput?.focus()); } })">

    <!-- Search Modal -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">

        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="open = false"></div>

        <!-- Modal Content -->
        <div class="relative min-h-screen flex items-start justify-center p-4 pt-[10vh]">
            <div @click.away="open = false"
                 class="relative bg-white dark:bg-dark-800 rounded-2xl shadow-2xl w-full max-w-2xl"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">

                <!-- Search Input -->
                <div class="p-4 border-b border-gray-200 dark:border-dark-700">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text"
                               x-model="query"
                               @input.debounce.300ms="search"
                               x-ref="searchInput"
                               placeholder="Search roadmaps, topics, resources... (Ctrl+K)"
                               class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 dark:border-dark-600 rounded-xl bg-white dark:bg-dark-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-900 transition-all"
                               autofocus>
                        <div x-show="loading" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <svg class="animate-spin h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Results -->
                <div class="max-h-96 overflow-y-auto p-4 space-y-4">
                    <!-- Roadmaps -->
                    <template x-if="results.roadmaps && results.roadmaps.length > 0">
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-2">ROADMAPS</h3>
                            <div class="space-y-2">
                                <template x-for="roadmap in results.roadmaps" :key="roadmap.id">
                                    <a :href="`/roadmaps/${roadmap.id}`"
                                       class="block p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-dark-700 transition-colors"
                                       @click="open = false">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <div class="font-semibold text-gray-900 dark:text-white" x-text="roadmap.title"></div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400" x-text="roadmap.description"></div>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full"
                                                  :class="{
                                                      'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400': roadmap.status === 'completed',
                                                      'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400': roadmap.status === 'in_progress',
                                                      'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300': roadmap.status === 'not_started'
                                                  }"
                                                  x-text="roadmap.status.replace('_', ' ')"></span>
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </template>

                    <!-- Topics -->
                    <template x-if="results.topics && results.topics.length > 0">
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-2">TOPICS</h3>
                            <div class="space-y-2">
                                <template x-for="topic in results.topics" :key="topic.id">
                                    <a :href="`/topics/${topic.id}`"
                                       class="block p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-dark-700 transition-colors"
                                       @click="open = false">
                                        <div class="font-semibold text-gray-900 dark:text-white" x-text="topic.title"></div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400" x-text="topic.roadmap?.title"></div>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </template>

                    <!-- Resources -->
                    <template x-if="results.resources && results.resources.length > 0">
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-2">RESOURCES</h3>
                            <div class="space-y-2">
                                <template x-for="resource in results.resources" :key="resource.id">
                                    <a :href="resource.url || '#'"
                                       class="block p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-dark-700 transition-colors"
                                       @click="open = false">
                                        <div class="font-semibold text-gray-900 dark:text-white" x-text="resource.title"></div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400" x-text="resource.type"></div>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </template>

                    <!-- Empty State -->
                    <template x-if="query.length >= 2 && !loading && !results.roadmaps?.length && !results.topics?.length && !results.resources?.length">
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="mt-2 text-gray-500 dark:text-gray-400">No results found</p>
                        </div>
                    </template>
                </div>

                <!-- Footer -->
                <div class="border-t border-gray-200 dark:border-dark-700 p-3 text-xs text-gray-500 dark:text-gray-400 flex items-center justify-between">
                    <span>Press ESC to close</span>
                    <span>Ctrl+K to open</span>
                </div>
            </div>
        </div>
    </div>
</div>
