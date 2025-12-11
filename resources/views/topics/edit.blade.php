<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-black text-3xl text-gray-900 leading-tight">
                Edit Topic
            </h2>
            <p class="mt-1 text-sm text-gray-600">{{ $topic->title }}</p>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl rounded-3xl border border-gray-200">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 text-white">
                    <h3 class="text-2xl font-black">Update Topic</h3>
                    <p class="text-indigo-100 text-sm mt-1">Modify the topic details below</p>
                </div>
                <form action="{{ route('topics.update', $topic) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-900 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Title <span class="text-red-500">*</span>
                            </span>
                        </label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title', $topic->title) }}"
                               required
                               class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 px-4 py-3 transition-all">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-900 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                </svg>
                                Description
                            </span>
                        </label>
                        <textarea name="description"
                                  id="description"
                                  rows="4"
                                  class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 px-4 py-3 transition-all">{{ old('description', $topic->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-bold text-gray-900 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Status
                            </span>
                        </label>
                        <select name="status"
                                id="status"
                                class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-4 py-3 transition-all">
                            <option value="not_started" {{ old('status', $topic->status) === 'not_started' ? 'selected' : '' }}>Not Started</option>
                            <option value="in_progress" {{ old('status', $topic->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ old('status', $topic->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estimated Hours & Actual Hours -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="estimated_hours" class="block text-sm font-bold text-gray-900 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Estimated Hours
                                </span>
                            </label>
                            <input type="number"
                                   name="estimated_hours"
                                   id="estimated_hours"
                                   value="{{ old('estimated_hours', $topic->estimated_hours) }}"
                                   min="0"
                                   step="0.5"
                                   class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 px-4 py-3 transition-all">
                            @error('estimated_hours')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="actual_hours" class="block text-sm font-bold text-gray-900 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Actual Hours
                                </span>
                            </label>
                            <input type="number"
                                   name="actual_hours"
                                   id="actual_hours"
                                   value="{{ old('actual_hours', $topic->actual_hours) }}"
                                   min="0"
                                   step="0.5"
                                   class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-500 px-4 py-3 transition-all">
                            @error('actual_hours')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Weightage & Order -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="weightage" class="block text-sm font-bold text-gray-900 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                    </svg>
                                    Weightage (0-100)
                                </span>
                            </label>
                            <input type="number"
                                   name="weightage"
                                   id="weightage"
                                   value="{{ old('weightage', $topic->weightage) }}"
                                   min="0"
                                   max="100"
                                   class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 px-4 py-3 transition-all">
                            @error('weightage')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="order" class="block text-sm font-bold text-gray-900 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                    </svg>
                                    Order
                                </span>
                            </label>
                            <input type="number"
                                   name="order"
                                   id="order"
                                   value="{{ old('order', $topic->order) }}"
                                   min="0"
                                   class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-500 px-4 py-3 transition-all">
                            @error('order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- File Attachments -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-3">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                </svg>
                                Attachments
                            </span>
                        </label>
                        <x-file-upload :existingFiles="$topic->attachments" />
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('topics.show', $topic) }}"
                           class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-all transform hover:scale-105">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all transform hover:scale-105">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Update Topic
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Delete Button -->
                <div class="border-t-2 border-gray-200 p-8 bg-red-50/50">
                    <h4 class="text-lg font-black text-red-900 mb-2">Danger Zone</h4>
                    <p class="text-sm text-red-700 mb-4">Deleting this topic will also delete all subtopics and resources. This action cannot be undone.</p>
                    <form action="{{ route('topics.destroy', $topic) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this topic? This will also delete all subtopics and resources.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Topic
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
