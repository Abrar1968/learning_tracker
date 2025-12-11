<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Topic: {{ $topic->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('topics.update', $topic) }}" method="POST" class="p-6">
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
                               value="{{ old('title', $topic->title) }}"
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
                                  rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $topic->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status
                        </label>
                        <select name="status" 
                                id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="not_started" {{ old('status', $topic->status) === 'not_started' ? 'selected' : '' }}>Not Started</option>
                            <option value="in_progress" {{ old('status', $topic->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ old('status', $topic->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estimated Hours & Actual Hours -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="estimated_hours" class="block text-sm font-medium text-gray-700 mb-2">
                                Estimated Hours
                            </label>
                            <input type="number" 
                                   name="estimated_hours" 
                                   id="estimated_hours" 
                                   value="{{ old('estimated_hours', $topic->estimated_hours) }}"
                                   min="0"
                                   step="0.5"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('estimated_hours')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="actual_hours" class="block text-sm font-medium text-gray-700 mb-2">
                                Actual Hours
                            </label>
                            <input type="number" 
                                   name="actual_hours" 
                                   id="actual_hours" 
                                   value="{{ old('actual_hours', $topic->actual_hours) }}"
                                   min="0"
                                   step="0.5"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('actual_hours')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Weightage & Order -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="weightage" class="block text-sm font-medium text-gray-700 mb-2">
                                Weightage (0-100)
                            </label>
                            <input type="number" 
                                   name="weightage" 
                                   id="weightage" 
                                   value="{{ old('weightage', $topic->weightage) }}"
                                   min="0"
                                   max="100"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('weightage')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                                Order
                            </label>
                            <input type="number" 
                                   name="order" 
                                   id="order" 
                                   value="{{ old('order', $topic->order) }}"
                                   min="0"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('order')
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
                            Update Topic
                        </button>
                    </div>
                </form>

                <!-- Delete Button -->
                <div class="border-t border-gray-200 p-6">
                    <form action="{{ route('topics.destroy', $topic) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this topic? This will also delete all subtopics and resources.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Delete Topic
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
