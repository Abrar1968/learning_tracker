@props(['key', 'description'])

<div class="flex items-center justify-between py-1.5">
    <span class="text-gray-600 dark:text-gray-300 text-sm">{{ $description }}</span>
    <kbd class="px-2 py-1 text-xs font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-dark-600 border border-gray-200 dark:border-dark-500 rounded shadow-sm">
        {{ $key }}
    </kbd>
</div>
