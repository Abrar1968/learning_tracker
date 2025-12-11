<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-black text-3xl text-gray-900 leading-tight">
                Add New Resource
            </h2>
            <p class="mt-1 text-sm text-gray-600">{{ $topic->title }}</p>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl rounded-3xl border border-gray-200">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-6 text-white">
                    <h3 class="text-2xl font-black">Resource Details</h3>
                    <p class="text-green-100 text-sm mt-1">Add learning materials and references</p>
                </div>
                <form action="{{ route('resources.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="p-8 space-y-6"
                      x-data="{ resourceType: '{{ old('type', 'article') }}' }">
                    @csrf
                    <input type="hidden" name="topic_id" value="{{ $topic->id }}">

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
                               value="{{ old('title') }}"
                               required
                               placeholder="e.g., Official React Documentation"
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
                                  placeholder="Brief description of this resource..."
                                  class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 px-4 py-3 transition-all">{{ old('description') }}</textarea>
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
                            <option value="video">Video</option>
                            <option value="article">Article</option>
                            <option value="book">Book</option>
                            <option value="course">Course</option>
                            <option value="documentation">Documentation</option>
                            <option value="other">Other</option>
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
                               value="{{ old('url') }}"
                               placeholder="https://example.com/resource"
                               class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-4 py-3 transition-all">
                        @error('url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- File upload -->
                    <div>
                        <label for="file" class="block text-sm font-bold text-gray-900 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                File (Optional)
                            </span>
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-gray-300 rounded-xl hover:border-orange-400 transition-colors bg-gray-50 hover:bg-orange-50">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="file" class="relative cursor-pointer rounded-md font-bold text-orange-600 hover:text-orange-700 focus-within:outline-none">
                                        <span>Upload a file</span>
                                        <input id="file" name="file" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF, DOCX, ZIP up to 10MB</p>
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
                                   value="{{ old('estimated_duration') }}"
                                   min="0"
                                   placeholder="60"
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
                                   value="{{ old('tags') }}"
                                   placeholder="react, hooks, frontend"
                                   class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-500 px-4 py-3 transition-all">
                            <p class="mt-1 text-xs text-gray-500 font-medium">Separate tags with commas</p>
                            @error('tags')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('topics.show', $topic) }}"
                           class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-all transform hover:scale-105">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all transform hover:scale-105">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Resource
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
