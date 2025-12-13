<div x-data="{
    toasts: [],
    addToast(message, type = 'info') {
        const id = Date.now();
        this.toasts.push({ id, message, type });
        setTimeout(() => this.removeToast(id), 5000);
    },
    removeToast(id) {
        this.toasts = this.toasts.filter(t => t.id !== id);
    }
}"
@toast.window="addToast($event.detail.message, $event.detail.type)"
class="fixed top-4 right-4 z-50 space-y-2">
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="true"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-x-full opacity-0"
             x-transition:enter-end="translate-x-0 opacity-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0 opacity-100"
             x-transition:leave-end="translate-x-full opacity-0"
             class="flex items-center space-x-3 px-6 py-4 rounded-lg shadow-lg min-w-[300px]"
             :class="{
                 'bg-green-500 text-white': toast.type === 'success',
                 'bg-red-500 text-white': toast.type === 'error',
                 'bg-blue-500 text-white': toast.type === 'info',
                 'bg-yellow-500 text-white': toast.type === 'warning'
             }">
            <div class="flex-1" x-text="toast.message"></div>
            <button @click="removeToast(toast.id)" class="text-white hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </template>
</div>
