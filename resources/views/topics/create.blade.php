<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Topic to {{ $roadmap->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('topics.store') }}" method="POST" class="p-6">
                    @csrf
                    <input type="hidden" name="roadmap_id" value="{{ $roadmap->id }}">

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
                                  rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Parent Topic & Estimated Hours -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Parent Topic (Optional)
                            </label>
                            <select name="parent_id" 
                                    id="parent_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">None (Root Topic)</option>
                                @foreach($roadmap->topics()->whereNull('parent_id')->get() as $topic)
                                    <option value="{{ $topic->id }}" {{ old('parent_id') == $topic->id ? 'selected' : '' }}>
                                        {{ $topic->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="estimated_hours" class="block text-sm font-medium text-gray-700 mb-2">
                                Estimated Hours
                            </label>
                            <input type="number" 
                                   name="estimated_hours" 
                                   id="estimated_hours" 
                                   value="{{ old('estimated_hours') }}"
                                   min="0"
                                   step="0.5"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('estimated_hours')
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
                                   value="{{ old('weightage', 1) }}"
                                   min="0"
                                   max="100"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="mt-1 text-xs text-gray-500">Used to calculate overall progress</p>
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
                                   value="{{ old('order', $roadmap->topics()->max('order') + 1) }}"
                                   min="0"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('roadmaps.show', $roadmap) }}" 
                           class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Add Topic
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
