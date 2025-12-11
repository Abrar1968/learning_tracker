<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Resource: {{ $resource->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('resources.update', $resource) }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      class="p-6"
                      x-data="{ resourceType: '{{ old('type', $resource->type) }}' }">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title', $resource->title) }}"
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $resource->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Resource Type -->
                    <div class="mb-6">
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                            Resource Type <span class="text-red-500">*</span>
                        </label>
                        <select name="type" 
                                id="type"
                                x-model="resourceType"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="video" {{ old('type', $resource->type) === 'video' ? 'selected' : '' }}>Video</option>
                            <option value="article" {{ old('type', $resource->type) === 'article' ? 'selected' : '' }}>Article</option>
                            <option value="book" {{ old('type', $resource->type) === 'book' ? 'selected' : '' }}>Book</option>
                            <option value="course" {{ old('type', $resource->type) === 'course' ? 'selected' : '' }}>Course</option>
                            <option value="documentation" {{ old('type', $resource->type) === 'documentation' ? 'selected' : '' }}>Documentation</option>
                            <option value="other" {{ old('type', $resource->type) === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- URL field -->
                    <div class="mb-6" x-show="resourceType !== 'other'">
                        <label for="url" class="block text-sm font-medium text-gray-700 mb-2">
                            URL
                        </label>
                        <input type="url" 
                               name="url" 
                               id="url" 
                               value="{{ old('url', $resource->url) }}"
                               placeholder="https://..."
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current File Info -->
                    @if($resource->file_path)
                        <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">
                                Current file: <span class="font-medium">{{ basename($resource->file_path) }}</span> 
                                ({{ $resource->getFileSizeFormatted() }})
                            </p>
                            <a href="{{ Storage::url($resource->file_path) }}" target="_blank" 
                               class="text-sm text-indigo-600 hover:text-indigo-800">
                                Download current file →
                            </a>
                        </div>
                    @endif

                    <!-- File upload -->
                    <div class="mb-6">
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $resource->file_path ? 'Replace File (Optional)' : 'File (Optional)' }}
                        </label>
                        <input type="file" 
                               name="file" 
                               id="file"
                               class="mt-1 block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-md file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-indigo-50 file:text-indigo-700
                                      hover:file:bg-indigo-100">
                        <p class="mt-1 text-xs text-gray-500">
                            {{ $resource->file_path ? 'Upload a new file to replace the existing one.' : 'Max file size: 10MB' }}
                        </p>
                        @error('file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estimated Duration & Tags -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="estimated_duration" class="block text-sm font-medium text-gray-700 mb-2">
                                Estimated Duration (minutes)
                            </label>
                            <input type="number" 
                                   name="estimated_duration" 
                                   id="estimated_duration" 
                                   value="{{ old('estimated_duration', $resource->estimated_duration) }}"
                                   min="0"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('estimated_duration')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">
                                Tags (comma separated)
                            </label>
                            <input type="text" 
                                   name="tags" 
                                   id="tags" 
                                   value="{{ old('tags', $resource->tags->pluck('tag_name')->implode(', ')) }}"
                                   placeholder="laravel, php, backend"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="mt-1 text-xs text-gray-500">Separate tags with commas</p>
                            @error('tags')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Is Completed Checkbox -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_completed" 
                                   value="1"
                                   {{ old('is_completed', $resource->is_completed) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-700">Mark as completed</span>
                        </label>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('topics.show', $resource->topic) }}" 
                           class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Update Resource
                        </button>
                    </div>
                </form>

                <!-- Delete Button -->
                <div class="border-t border-gray-200 p-6">
                    <form action="{{ route('resources.destroy', $resource) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this resource?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Delete Resource
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
