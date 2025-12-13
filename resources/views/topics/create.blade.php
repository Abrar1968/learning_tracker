<x-layouts.app-with-sidebar>
    <x-slot name="header">
        <div>
            <h2 class="font-black text-3xl text-gray-900 leading-tight">
                Add New Topic
            </h2>
            <p class="mt-1 text-sm text-gray-600">{{ $roadmap->title }}</p>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl rounded-3xl border border-gray-200">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 text-white">
                    <h3 class="text-2xl font-black">Topic Details</h3>
                    <p class="text-indigo-100 text-sm mt-1">Add a new learning module to your roadmap</p>
                </div>
                <form action="{{ route('roadmaps.topics.store', $roadmap) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                    @csrf
                    <input type="hidden" name="roadmap_id" value="{{ $roadmap->id }}">

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
                               value="{{ old('title') }}"
                               required
                               placeholder="e.g., Introduction to React Hooks"
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
                                  placeholder="What will you learn in this topic..."
                                  class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 px-4 py-3 transition-all">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Parent Topic & Estimated Hours -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="parent_id" class="block text-sm font-bold text-gray-900 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                    </svg>
                                    Parent Topic (Optional)
                                </span>
                            </label>
                            <select name="parent_id"
                                    id="parent_id"
                                    class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 px-4 py-3 transition-all">
                                <option value="">None (Root Topic)</option>
                                @foreach($roadmap->topics()->whereNull('parent_id')->get() as $topic)
                                    <option value="{{ $topic->id }}" {{ old('parent_id', request('parent_id')) == $topic->id ? 'selected' : '' }}>
                                        {{ $topic->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="estimated_hours" class="block text-sm font-bold text-gray-900 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Estimated Hours
                                </span>
                            </label>
                            <input type="number"
                                   name="estimated_hours"
                                   id="estimated_hours"
                                   value="{{ old('estimated_hours') }}"
                                   min="0"
                                   step="0.5"
                                   placeholder="10"
                                   class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-4 py-3 transition-all">
                            @error('estimated_hours')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Weightage & Order -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="weightage" class="block text-sm font-bold text-gray-900 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                    </svg>
                                    Weightage (0-100)
                                </span>
                            </label>
                            <input type="number"
                                   name="weightage"
                                   id="weightage"
                                   value="{{ old('weightage', 1) }}"
                                   min="0"
                                   max="100"
                                   class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 px-4 py-3 transition-all">
                            <p class="mt-1 text-xs text-gray-500">Used to calculate overall progress</p>
                            @error('weightage')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="order" class="block text-sm font-bold text-gray-900 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                    </svg>
                                    Order
                                </span>
                            </label>
                            <input type="number"
                                   name="order"
                                   id="order"
                                   value="{{ old('order', $roadmap->topics()->max('order') + 1) }}"
                                   min="0"
                                   class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-500 px-4 py-3 transition-all">
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
                                Attachments (Optional)
                            </span>
                        </label>
                        <x-file-upload />
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('roadmaps.show', $roadmap) }}"
                           class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-all transform hover:scale-105">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all transform hover:scale-105">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Topic
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app-with-sidebar>
