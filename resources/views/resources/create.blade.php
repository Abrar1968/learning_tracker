<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Resource to {{ $topic->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('resources.store') }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      class="p-6"
                      x-data="{ resourceType: '{{ old('type', 'article') }}' }">
                    @csrf
                    <input type="hidden" name="topic_id" value="{{ $topic->id }}">

                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title') }}"
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
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
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
                    <div class="mb-6" x-show="resourceType !== 'other'">
                        <label for="url" class="block text-sm font-medium text-gray-700 mb-2">
                            URL
                        </label>
                        <input type="url" 
                               name="url" 
                               id="url" 
                               value="{{ old('url') }}"
                               placeholder="https://..."
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- File upload -->
                    <div class="mb-6">
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                            File (Optional)
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
                        <p class="mt-1 text-xs text-gray-500">Max file size: 10MB. Supported formats: PDF, DOCX, ZIP, etc.</p>
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
                                   value="{{ old('estimated_duration') }}"
                                   min="0"
                                   placeholder="60"
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
                                   value="{{ old('tags') }}"
                                   placeholder="laravel, php, backend"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="mt-1 text-xs text-gray-500">Separate tags with commas</p>
                            @error('tags')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('topics.show', $topic) }}" 
                           class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Add Resource
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
