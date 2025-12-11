@props(['existingFiles' => []])

<div x-data="{
    files: [],
    isDragging: false,
    addFiles(event) {
        const newFiles = Array.from(event.target.files || event.dataTransfer.files);
        this.files = [...this.files, ...newFiles.map(file => ({
            file: file,
            name: file.name,
            size: this.formatSize(file.size),
            type: file.type,
            preview: this.getPreview(file)
        }))];
    },
    removeFile(index) {
        this.files.splice(index, 1);
    },
    formatSize(bytes) {
        if (bytes >= 1073741824) return (bytes / 1073741824).toFixed(2) + ' GB';
        if (bytes >= 1048576) return (bytes / 1048576).toFixed(2) + ' MB';
        if (bytes >= 1024) return (bytes / 1024).toFixed(2) + ' KB';
        return bytes + ' bytes';
    },
    getPreview(file) {
        if (file.type.startsWith('image/')) {
            return URL.createObjectURL(file);
        }
        return null;
    }
}" class="space-y-4">

    <!-- Drop Zone -->
    <div
        @dragover.prevent="isDragging = true"
        @dragleave.prevent="isDragging = false"
        @drop.prevent="isDragging = false; addFiles($event)"
        :class="{ 'border-indigo-500 bg-indigo-50': isDragging }"
        class="relative border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-indigo-400 transition-all duration-300 cursor-pointer group">

        <input
            type="file"
            name="attachments[]"
            multiple
            @change="addFiles($event)"
            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
            accept="image/*,.pdf,.doc,.docx,.txt,.md,.xls,.xlsx,.ppt,.pptx,.zip">

        <div class="space-y-3">
            <div class="w-16 h-16 mx-auto bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
            </div>
            <div>
                <p class="text-lg font-bold text-gray-700">Drop files here or click to upload</p>
                <p class="text-sm text-gray-500 mt-1">
                    Images, PDFs, Documents (Max 10MB per file)
                </p>
            </div>
            <div class="flex flex-wrap justify-center gap-2 pt-2">
                <span class="px-3 py-1 bg-gray-100 rounded-full text-xs font-semibold text-gray-600">📷 Images</span>
                <span class="px-3 py-1 bg-gray-100 rounded-full text-xs font-semibold text-gray-600">📄 PDFs</span>
                <span class="px-3 py-1 bg-gray-100 rounded-full text-xs font-semibold text-gray-600">📝 Docs</span>
                <span class="px-3 py-1 bg-gray-100 rounded-full text-xs font-semibold text-gray-600">📊 Sheets</span>
            </div>
        </div>
    </div>

    <!-- Selected Files Preview -->
    <template x-if="files.length > 0">
        <div class="space-y-3">
            <h4 class="font-bold text-gray-700 flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span x-text="files.length + ' file(s) selected'"></span>
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <template x-for="(item, index) in files" :key="index">
                    <div class="flex items-center space-x-3 p-3 bg-white border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                        <!-- Preview -->
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-lg flex items-center justify-center overflow-hidden">
                            <template x-if="item.preview">
                                <img :src="item.preview" :alt="item.name" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!item.preview">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </template>
                        </div>

                        <!-- File Info -->
                        <div class="flex-grow min-w-0">
                            <p class="text-sm font-semibold text-gray-700 truncate" x-text="item.name"></p>
                            <p class="text-xs text-gray-500" x-text="item.size"></p>
                        </div>

                        <!-- Remove Button -->
                        <button
                            type="button"
                            @click="removeFile(index)"
                            class="flex-shrink-0 text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </template>

    <!-- Existing Files -->
    @if(count($existingFiles) > 0)
        <div class="space-y-3 border-t pt-4">
            <h4 class="font-bold text-gray-700 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Existing Attachments ({{ count($existingFiles) }})
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($existingFiles as $file)
                    <div class="flex items-center space-x-3 p-3 bg-green-50 border border-green-200 rounded-lg group">
                        <!-- Preview -->
                        <div class="flex-shrink-0 w-12 h-12 bg-white rounded-lg flex items-center justify-center overflow-hidden">
                            @if($file->isImage())
                                <img src="{{ $file->url }}" alt="{{ $file->original_name }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            @endif
                        </div>

                        <!-- File Info -->
                        <div class="flex-grow min-w-0">
                            <a href="{{ $file->url }}" target="_blank" class="text-sm font-semibold text-gray-700 hover:text-indigo-600 truncate block">
                                {{ $file->original_name }}
                            </a>
                            <p class="text-xs text-gray-500">{{ $file->formatted_size }}</p>
                        </div>

                        <!-- Delete Button -->
                        <form action="{{ route('attachments.destroy', $file->id) }}" method="POST" class="flex-shrink-0"
                              onsubmit="return confirm('Are you sure you want to delete this file?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 hover:bg-red-100 p-2 rounded-lg transition-colors opacity-0 group-hover:opacity-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
