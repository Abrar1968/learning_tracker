<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-black text-3xl text-gray-900 leading-tight">
                Edit Resource
            </h2>
            <p class="mt-1 text-sm text-gray-600">{{ $resource->title }}</p>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl rounded-3xl border border-gray-200">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-6 text-white">
                    <h3 class="text-2xl font-black">Update Resource</h3>
                    <p class="text-green-100 text-sm mt-1">Modify the resource details below</p>
                </div>
                <form action="{{ route('resources.update', $resource) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="p-8 space-y-6"
                      x-data="{ resourceType: '{{ old('type', $resource->type) }}' }">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-900 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Title <span class="text-red-500">*</span>
                            </span>
                        </label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title', $resource->title) }}"
                               required
                               class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 px-4 py-3 transition-all">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-900 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                </svg>
                                Description
                            </span>
                        </label>
                        <textarea name="description"
                                  id="description"
                                  rows="3"
                                  class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 px-4 py-3 transition-all">{{ old('description', $resource->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Resource Type -->
                    <div>
                        <label for="type" class="block text-sm font-bold text-gray-900 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                </svg>
                                Resource Type <span class="text-red-500">*</span>
                            </span>
                        </label>
                        <select name="type"
                                id="type"
                                x-model="resourceType"
                                required
                                class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 px-4 py-3 transition-all">
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
                    <div x-show="resourceType !== 'other'">
                        <label for="url" class="block text-sm font-bold text-gray-900 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                                URL
                            </span>
                        </label>
                        <input type="url"
                               name="url"
                               id="url"
                               value="{{ old('url', $resource->url) }}"
                               placeholder="https://example.com/resource"
                               class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-4 py-3 transition-all">
                        @error('url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current File Info -->
                    @if($resource->file_path)
                        <div class="p-5 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl border-2 border-blue-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-blue-100 p-3 rounded-xl">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">Current File</p>
                                        <p class="text-xs text-gray-600">{{ basename($resource->file_path) }} ({{ $resource->getFileSizeFormatted() }})</p>
                                    </div>
                                </div>
                                <a href="{{ Storage::url($resource->file_path) }}" target="_blank"
                                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm transition-all transform hover:scale-105 shadow-lg">
                                    Download
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- File upload -->
                    <div>
                        <label for="file" class="block text-sm font-bold text-gray-900 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                {{ $resource->file_path ? 'Replace File (Optional)' : 'File (Optional)' }}
                            </span>
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-gray-300 rounded-xl hover:border-orange-400 transition-colors bg-gray-50 hover:bg-orange-50">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="file" class="relative cursor-pointer rounded-md font-bold text-orange-600 hover:text-orange-700">
                                        <span>{{ $resource->file_path ? 'Upload new file' : 'Upload a file' }}</span>
                                        <input id="file" name="file" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    {{ $resource->file_path ? 'This will replace the existing file' : 'PDF, DOCX, ZIP up to 10MB' }}
                                </p>
                            </div>
                        </div>
                        @error('file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estimated Duration & Tags -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="estimated_duration" class="block text-sm font-bold text-gray-900 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Duration (minutes)
                                </span>
                            </label>
                            <input type="number"
                                   name="estimated_duration"
                                   id="estimated_duration"
                                   value="{{ old('estimated_duration', $resource->estimated_duration) }}"
                                   min="0"
                                   class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 px-4 py-3 transition-all">
                            @error('estimated_duration')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tags" class="block text-sm font-bold text-gray-900 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    Tags
                                </span>
                            </label>
                            <input type="text"
                                   name="tags"
                                   id="tags"
                                   value="{{ old('tags', $resource->tags->pluck('tag_name')->implode(', ')) }}"
                                   placeholder="react, hooks, frontend"
                                   class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-500 px-4 py-3 transition-all">
                            <p class="mt-1 text-xs text-gray-500 font-medium">Separate tags with commas</p>
                            @error('tags')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Is Completed Checkbox -->
                    <div class="p-4 bg-green-50 rounded-2xl border-2 border-green-200">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox"
                                   name="is_completed"
                                   value="1"
                                   {{ old('is_completed', $resource->is_completed) ? 'checked' : '' }}
                                   class="w-5 h-5 rounded border-gray-300 text-green-600 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500">
                            <span class="ml-3 text-sm font-bold text-gray-900">Mark as completed</span>
                        </label>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('topics.show', $resource->topic) }}"
                           class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-all transform hover:scale-105">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all transform hover:scale-105">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Update Resource
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Delete Button -->
                <div class="border-t-2 border-gray-200 p-8 bg-red-50/50">
                    <h4 class="text-lg font-black text-red-900 mb-2">Danger Zone</h4>
                    <p class="text-sm text-red-700 mb-4">Permanently delete this resource. This action cannot be undone.</p>
                    <form action="{{ route('resources.destroy', $resource) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this resource?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Resource
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
