# Frontend Architecture Documentation
## Learning Progress Tracker - Tailwind CSS v4 + Alpine.js + Blade Templates

**Version:** 1.0  
**Last Updated:** December 11, 2025  
**Framework:** Laravel 12.x with Blade Templating  
**Stack:** Blade Templates, Alpine.js 3.x, Tailwind CSS v4.x, HTML5

---

## Table of Contents

1. [Architecture Overview](#architecture-overview)
2. [Technology Stack](#technology-stack)
3. [Directory Structure](#directory-structure)
4. [Blade Templates](#blade-templates)
5. [Alpine.js Implementation](#alpinejs-implementation)
6. [Tailwind CSS v4 Setup](#tailwind-css-v4-setup)
7. [Component Library](#component-library)
8. [Page Layouts](#page-layouts)
9. [Interactive Features](#interactive-features)
10. [Forms & Validation](#forms--validation)
11. [Asset Management](#asset-management)
12. [Responsive Design](#responsive-design)
13. [Animations & Transitions](#animations--transitions)
14. [Performance Optimization](#performance-optimization)
15. [Accessibility](#accessibility)
16. [Best Practices](#best-practices)

---

## Architecture Overview

### Frontend Stack Philosophy

The Learning Progress Tracker uses a **modern, lightweight** frontend stack that prioritizes:

- **Server-Side Rendering**: Blade templates for SEO and initial load performance
- **Progressive Enhancement**: Alpine.js for interactive features without heavy JavaScript
- **Utility-First CSS**: Tailwind CSS v4 for rapid, consistent styling
- **Component-Based**: Reusable Blade components for maintainability
- **Performance**: Minimal JavaScript, optimized assets, lazy loading

```
┌─────────────────────────────────────────────┐
│         Browser (Client Side)                │
│                                              │
│  ┌──────────────────────────────────────┐  │
│  │     Alpine.js (Reactivity)           │  │
│  │  - Interactive UI components         │  │
│  │  - Form validation                   │  │
│  │  - State management                  │  │
│  └──────────────────────────────────────┘  │
│                                              │
│  ┌──────────────────────────────────────┐  │
│  │   Tailwind CSS v4 (Styling)          │  │
│  │  - Utility classes                   │  │
│  │  - Custom components                 │  │
│  │  - Responsive design                 │  │
│  └──────────────────────────────────────┘  │
│                                              │
│  ┌──────────────────────────────────────┐  │
│  │   HTML (Blade Rendered)              │  │
│  │  - Semantic markup                   │  │
│  │  - Server-side rendered              │  │
│  │  - SEO optimized                     │  │
│  └──────────────────────────────────────┘  │
└─────────────────────────────────────────────┘
```

---

## Technology Stack

### Core Technologies

**Blade Templating Engine (Laravel Native)**
- Server-side rendering
- Component-based architecture
- Template inheritance
- Directive-based logic
- Built-in CSRF protection

**Alpine.js v3.x**
- Lightweight (15kb min+gzip)
- Declarative syntax
- No build step required
- Reactive data binding
- Component-like functionality

**Tailwind CSS v4.x**
- Utility-first CSS framework
- JIT (Just-In-Time) compiler
- Custom design system
- Responsive utilities
- Dark mode support (future)

### Additional Libraries

**Chart.js** - Progress visualizations
```html
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
```

**Sortable.js** - Drag-and-drop functionality
```html
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
```

**FilePond** - File uploads with preview
```html
<link href="https://unpkg.com/filepond@4.30.4/dist/filepond.min.css" rel="stylesheet">
<script src="https://unpkg.com/filepond@4.30.4/dist/filepond.min.js"></script>
```

**Tippy.js** - Tooltips and popovers
```html
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
```

**Day.js** - Date formatting
```html
<script src="https://cdn.jsdelivr.net/npm/dayjs@1.11.10/dayjs.min.js"></script>
```

---

## Directory Structure

```
resources/
├── views/
│   ├── layouts/
│   │   ├── app.blade.php              # Main application layout
│   │   ├── guest.blade.php            # Guest/auth layout
│   │   └── certificate.blade.php      # Certificate PDF layout
│   ├── components/
│   │   ├── button.blade.php
│   │   ├── card.blade.php
│   │   ├── input.blade.php
│   │   ├── modal.blade.php
│   │   ├── progress-bar.blade.php
│   │   ├── roadmap-card.blade.php
│   │   ├── topic-item.blade.php
│   │   ├── resource-item.blade.php
│   │   ├── navbar.blade.php
│   │   ├── sidebar.blade.php
│   │   ├── alert.blade.php
│   │   └── loading-spinner.blade.php
│   ├── auth/
│   │   ├── login.blade.php
│   │   ├── register.blade.php
│   │   ├── forgot-password.blade.php
│   │   └── reset-password.blade.php
│   ├── dashboard/
│   │   └── index.blade.php
│   ├── roadmaps/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   ├── show.blade.php
│   │   └── public.blade.php
│   ├── topics/
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── partials/
│   │       ├── topic-form.blade.php
│   │       └── topic-list.blade.php
│   ├── resources/
│   │   ├── create.blade.php
│   │   └── partials/
│   │       └── resource-list.blade.php
│   ├── certificates/
│   │   ├── index.blade.php
│   │   ├── show.blade.php
│   │   ├── verify.blade.php
│   │   └── templates/
│   │       ├── modern.blade.php
│   │       ├── classic.blade.php
│   │       └── minimal.blade.php
│   ├── profile/
│   │   ├── edit.blade.php
│   │   └── show.blade.php
│   └── welcome.blade.php
├── css/
│   ├── app.css                        # Main Tailwind entry point
│   └── components/                     # Custom component styles
│       ├── buttons.css
│       ├── cards.css
│       └── forms.css
└── js/
    ├── app.js                         # Main JavaScript entry
    ├── bootstrap.js                   # Laravel bootstrap
    └── components/
        ├── file-upload.js
        ├── drag-drop.js
        ├── charts.js
        └── tooltips.js
```

---

## Blade Templates

### Main Layout (app.blade.php)

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Learning Tracker') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        <!-- Navbar -->
        <x-navbar />

        <!-- Sidebar (Mobile) -->
        <x-sidebar />

        <!-- Main Content -->
        <main class="lg:pl-64 pt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Flash Messages -->
                @if(session('success'))
                    <x-alert type="success" :message="session('success')" />
                @endif

                @if(session('error'))
                    <x-alert type="error" :message="session('error')" />
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
```

### Reusable Components

#### Button Component

```blade
{{-- resources/views/components/button.blade.php --}}
@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'icon' => null,
])

@php
$baseClasses = 'inline-flex items-center justify-center font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2';

$variants = [
    'primary' => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500',
    'secondary' => 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 focus:ring-indigo-500',
    'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
    'success' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500',
];

$sizes = [
    'sm' => 'px-3 py-1.5 text-sm rounded-md',
    'md' => 'px-4 py-2 text-base rounded-lg',
    'lg' => 'px-6 py-3 text-lg rounded-lg',
];

$classes = $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size];
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <x-icon :name="$icon" class="w-5 h-5 mr-2" />
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <x-icon :name="$icon" class="w-5 h-5 mr-2" />
        @endif
        {{ $slot }}
    </button>
@endif
```

#### Card Component

```blade
{{-- resources/views/components/card.blade.php --}}
@props([
    'title' => null,
    'footer' => null,
    'padding' => true,
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200']) }}>
    @if($title)
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
        </div>
    @endif

    <div class="{{ $padding ? 'p-6' : '' }}">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-xl">
            {{ $footer }}
        </div>
    @endif
</div>
```

#### Progress Bar Component

```blade
{{-- resources/views/components/progress-bar.blade.php --}}
@props([
    'percentage' => 0,
    'color' => 'indigo',
    'showLabel' => true,
    'size' => 'md',
])

@php
$heights = [
    'sm' => 'h-2',
    'md' => 'h-4',
    'lg' => 'h-6',
];

$colors = [
    'indigo' => 'bg-indigo-600',
    'green' => 'bg-green-600',
    'blue' => 'bg-blue-600',
    'yellow' => 'bg-yellow-500',
    'red' => 'bg-red-600',
];
@endphp

<div {{ $attributes->merge(['class' => 'w-full']) }}>
    @if($showLabel)
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-medium text-gray-700">Progress</span>
            <span class="text-sm font-semibold text-gray-900">{{ number_format($percentage, 0) }}%</span>
        </div>
    @endif

    <div class="w-full bg-gray-200 rounded-full {{ $heights[$size] }} overflow-hidden">
        <div 
            class="{{ $colors[$color] }} {{ $heights[$size] }} rounded-full transition-all duration-500 ease-out"
            style="width: {{ $percentage }}%"
            x-data="{ width: 0 }"
            x-init="setTimeout(() => width = {{ $percentage }}, 100)"
            :style="`width: ${width}%`"
        ></div>
    </div>
</div>
```

#### Roadmap Card Component

```blade
{{-- resources/views/components/roadmap-card.blade.php --}}
@props(['roadmap'])

<a href="{{ route('roadmaps.show', $roadmap) }}" 
   class="block group">
    <x-card class="hover:scale-102 transition-transform duration-200">
        <div class="space-y-4">
            <!-- Header -->
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h3 class="text-xl font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">
                        {{ $roadmap->title }}
                    </h3>
                    @if($roadmap->category)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 mt-2">
                            {{ $roadmap->category }}
                        </span>
                    @endif
                </div>

                @if($roadmap->difficulty_level)
                    <span class="px-2 py-1 text-xs font-medium rounded-md
                        {{ $roadmap->difficulty_level === 'beginner' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $roadmap->difficulty_level === 'intermediate' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $roadmap->difficulty_level === 'advanced' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($roadmap->difficulty_level) }}
                    </span>
                @endif
            </div>

            <!-- Description -->
            @if($roadmap->description)
                <p class="text-gray-600 text-sm line-clamp-2">
                    {{ $roadmap->description }}
                </p>
            @endif

            <!-- Progress -->
            <x-progress-bar 
                :percentage="$roadmap->progress_percentage" 
                color="indigo"
                size="md"
            />

            <!-- Stats -->
            <div class="flex items-center justify-between text-sm text-gray-500 pt-4 border-t border-gray-100">
                <div class="flex items-center space-x-4">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        {{ $roadmap->completed_topics }}/{{ $roadmap->total_topics }} Topics
                    </span>
                </div>

                <span class="text-xs text-gray-400">
                    Updated {{ $roadmap->updated_at->diffForHumans() }}
                </span>
            </div>
        </div>
    </x-card>
</a>
```

---

## Alpine.js Implementation

### Data Management

```blade
{{-- Dashboard with Alpine.js state --}}
@extends('layouts.app')

@section('content')
<div x-data="{
    filter: 'all',
    search: '',
    roadmaps: @js($roadmaps),
    
    get filteredRoadmaps() {
        let filtered = this.roadmaps;
        
        // Filter by status
        if (this.filter !== 'all') {
            filtered = filtered.filter(r => r.status === this.filter);
        }
        
        // Search
        if (this.search) {
            filtered = filtered.filter(r => 
                r.title.toLowerCase().includes(this.search.toLowerCase()) ||
                r.description.toLowerCase().includes(this.search.toLowerCase())
            );
        }
        
        return filtered;
    }
}">
    <!-- Filter Buttons -->
    <div class="flex items-center space-x-2 mb-6">
        <button 
            @click="filter = 'all'"
            :class="filter === 'all' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700'"
            class="px-4 py-2 rounded-lg border border-gray-300 transition-colors">
            All
        </button>
        <button 
            @click="filter = 'active'"
            :class="filter === 'active' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700'"
            class="px-4 py-2 rounded-lg border border-gray-300 transition-colors">
            Active
        </button>
        <button 
            @click="filter = 'completed'"
            :class="filter === 'completed' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700'"
            class="px-4 py-2 rounded-lg border border-gray-300 transition-colors">
            Completed
        </button>
    </div>

    <!-- Search -->
    <input 
        type="text" 
        x-model="search"
        placeholder="Search roadmaps..."
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 mb-6">

    <!-- Roadmap Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="roadmap in filteredRoadmaps" :key="roadmap.id">
            <div>
                <x-roadmap-card :roadmap="roadmap" />
            </div>
        </template>
    </div>

    <!-- Empty State -->
    <div x-show="filteredRoadmaps.length === 0" class="text-center py-12">
        <p class="text-gray-500">No roadmaps found</p>
    </div>
</div>
@endsection
```

### Modal Component with Alpine.js

```blade
{{-- resources/views/components/modal.blade.php --}}
@props([
    'name',
    'show' => false,
    'maxWidth' => 'md'
])

@php
$maxWidthClasses = [
    'sm' => 'max-w-sm',
    'md' => 'max-w-md',
    'lg' => 'max-w-lg',
    'xl' => 'max-w-xl',
    '2xl' => 'max-w-2xl',
];
@endphp

<div
    x-data="{ show: @js($show) }"
    x-on:open-modal.window="$event.detail === '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail === '{{ $name }}' ? show = false : null"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    <!-- Overlay -->
    <div 
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        @click="show = false"
    ></div>

    <!-- Modal -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="bg-white rounded-lg shadow-xl transform transition-all {{ $maxWidthClasses[$maxWidth] }} w-full"
            @click.away="show = false"
        >
            {{ $slot }}
        </div>
    </div>
</div>
```

### Topic Management with Drag & Drop

```blade
<div x-data="topicManager()" x-init="initSortable()">
    <div id="topics-list" class="space-y-4">
        @foreach($roadmap->topics as $topic)
            <div 
                data-topic-id="{{ $topic->id }}"
                class="bg-white p-4 rounded-lg border border-gray-200 cursor-move hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <!-- Drag Handle -->
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                        </svg>

                        <!-- Checkbox -->
                        <input 
                            type="checkbox" 
                            @change="updateTopicStatus({{ $topic->id }}, $event.target.checked)"
                            {{ $topic->status === 'completed' ? 'checked' : '' }}
                            class="w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500">

                        <!-- Topic Info -->
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900">{{ $topic->title }}</h4>
                            <p class="text-sm text-gray-500">{{ $topic->estimated_hours }} hours</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-2">
                        <button @click="editTopic({{ $topic->id }})" class="text-indigo-600 hover:text-indigo-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button @click="deleteTopic({{ $topic->id }})" class="text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
function topicManager() {
    return {
        sortable: null,
        
        initSortable() {
            this.sortable = Sortable.create(document.getElementById('topics-list'), {
                animation: 150,
                handle: 'svg',
                onEnd: (evt) => {
                    this.saveOrder();
                }
            });
        },
        
        async updateTopicStatus(topicId, isCompleted) {
            const status = isCompleted ? 'completed' : 'not_started';
            
            try {
                const response = await fetch(`/topics/${topicId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ status })
                });
                
                if (response.ok) {
                    // Refresh progress
                    window.location.reload();
                }
            } catch (error) {
                console.error('Error updating topic status:', error);
            }
        },
        
        async saveOrder() {
            const topicIds = Array.from(document.querySelectorAll('[data-topic-id]'))
                .map(el => el.dataset.topicId);
            
            try {
                await fetch(`/roadmaps/{{ $roadmap->id }}/reorder`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ topic_ids: topicIds })
                });
            } catch (error) {
                console.error('Error saving order:', error);
            }
        },
        
        editTopic(topicId) {
            window.location.href = `/topics/${topicId}/edit`;
        },
        
        deleteTopic(topicId) {
            if (confirm('Are you sure you want to delete this topic?')) {
                document.getElementById(`delete-form-${topicId}`).submit();
            }
        }
    }
}
</script>
@endpush
```

---

## Tailwind CSS v4 Setup

### Configuration (tailwind.config.js)

```javascript
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#eef2ff',
          100: '#e0e7ff',
          200: '#c7d2fe',
          300: '#a5b4fc',
          400: '#818cf8',
          500: '#6366f1',
          600: '#4f46e5',
          700: '#4338ca',
          800: '#3730a3',
          900: '#312e81',
        },
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
      },
      animation: {
        'fade-in': 'fadeIn 0.3s ease-in',
        'slide-in': 'slideIn 0.3s ease-out',
        'scale-up': 'scaleUp 0.2s ease-out',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideIn: {
          '0%': { transform: 'translateY(20px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        scaleUp: {
          '0%': { transform: 'scale(0.95)', opacity: '0' },
          '100%': { transform: 'scale(1)', opacity: '1' },
        },
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}
```

### Main CSS File (resources/css/app.css)

```css
@tailwind base;
@tailwind components;
@tailwind utilities;

@layer base {
  html {
    scroll-behavior: smooth;
  }

  body {
    @apply text-gray-900;
  }

  h1, h2, h3, h4, h5, h6 {
    @apply font-semibold;
  }
}

@layer components {
  /* Custom Button Styles */
  .btn {
    @apply inline-flex items-center justify-center font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed;
  }

  .btn-primary {
    @apply bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500;
  }

  .btn-secondary {
    @apply bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 focus:ring-primary-500;
  }

  /* Custom Card Styles */
  .card {
    @apply bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200;
  }

  .card-hover {
    @apply transform hover:-translate-y-1 transition-transform duration-200;
  }

  /* Form Input Styles */
  .input {
    @apply w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200;
  }

  .input-error {
    @apply border-red-500 focus:ring-red-500 focus:border-red-500;
  }

  /* Progress Bar */
  .progress-bar {
    @apply w-full bg-gray-200 rounded-full h-4 overflow-hidden;
  }

  .progress-fill {
    @apply bg-primary-600 h-full rounded-full transition-all duration-500 ease-out;
  }
}

@layer utilities {
  .line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .hover-scale-102 {
    @apply hover:scale-102;
  }

  .scale-102 {
    transform: scale(1.02);
  }
}
```

---

## Forms & Validation

### Form with Real-time Validation

```blade
<form 
    x-data="{
        title: '{{ old('title', $roadmap->title ?? '') }}',
        description: '{{ old('description', $roadmap->description ?? '') }}',
        errors: {},
        
        validate() {
            this.errors = {};
            
            if (!this.title || this.title.length < 3) {
                this.errors.title = 'Title must be at least 3 characters';
            }
            
            if (this.title.length > 255) {
                this.errors.title = 'Title must not exceed 255 characters';
            }
            
            return Object.keys(this.errors).length === 0;
        },
        
        submit() {
            if (this.validate()) {
                $el.submit();
            }
        }
    }"
    @submit.prevent="submit"
    method="POST"
    action="{{ route('roadmaps.store') }}"
    class="space-y-6">
    
    @csrf

    <!-- Title Field -->
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
            Roadmap Title <span class="text-red-500">*</span>
        </label>
        <input 
            type="text" 
            id="title"
            name="title"
            x-model="title"
            @input="validate"
            class="input"
            :class="{ 'input-error': errors.title || @error('title') true @enderror }"
            placeholder="e.g., Full Stack Developer Roadmap">
        
        <!-- Validation Error -->
        <p x-show="errors.title" x-text="errors.title" class="mt-1 text-sm text-red-600"></p>
        
        <!-- Server Error -->
        @error('title')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror

        <!-- Character Counter -->
        <p class="mt-1 text-sm text-gray-500">
            <span x-text="title.length"></span> / 255 characters
        </p>
    </div>

    <!-- Description Field -->
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
            Description
        </label>
        <textarea 
            id="description"
            name="description"
            x-model="description"
            rows="4"
            class="input"
            placeholder="Describe your learning journey..."></textarea>
        
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Submit Button -->
    <div class="flex items-center justify-end space-x-4">
        <a href="{{ route('roadmaps.index') }}" class="btn btn-secondary px-6 py-2 rounded-lg">
            Cancel
        </a>
        <button type="submit" class="btn btn-primary px-6 py-2 rounded-lg">
            Create Roadmap
        </button>
    </div>
</form>
```

---

## Performance Optimization

### 1. Asset Optimization

```javascript
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    'vendor': ['alpinejs'],
                },
            },
        },
    },
});
```

### 2. Lazy Loading Images

```blade
<img 
    src="{{ $roadmap->thumbnail_url }}" 
    alt="{{ $roadmap->title }}"
    loading="lazy"
    class="w-full h-48 object-cover rounded-t-lg">
```

### 3. Defer Non-Critical JavaScript

```blade
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
@endpush
```

---

## Accessibility

### 1. Semantic HTML

```blade
<nav aria-label="Main navigation">
    <ul role="list">
        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('roadmaps.index') }}">Roadmaps</a></li>
    </ul>
</nav>
```

### 2. ARIA Labels

```blade
<button 
    aria-label="Delete roadmap"
    @click="deleteRoadmap">
    <svg aria-hidden="true">...</svg>
</button>
```

### 3. Focus Management

```css
.btn:focus-visible {
    @apply ring-2 ring-offset-2 ring-primary-500 outline-none;
}
```

---

## Best Practices

### 1. Component Organization
- Keep components small and focused
- Use slots for flexibility
- Props for configuration
- Consistent naming conventions

### 2. Alpine.js Guidelines
- Use x-data for component state
- Avoid complex logic in templates
- Extract reusable functions
- Use x-init sparingly

### 3. Tailwind CSS Guidelines
- Use utility classes first
- Extract components with @apply carefully
- Follow mobile-first approach
- Keep custom CSS minimal

### 4. Performance
- Lazy load images
- Defer non-critical scripts
- Minimize Alpine.js watchers
- Use CSS transitions over JavaScript

### 5. Accessibility
- Semantic HTML structure
- ARIA labels where needed
- Keyboard navigation support
- Focus states visible
- Color contrast compliance

---

## Conclusion

This frontend architecture provides a modern, performant, and maintainable solution for the Learning Progress Tracker platform. The combination of Blade templates, Alpine.js, and Tailwind CSS v4 offers excellent developer experience while maintaining high performance and accessibility standards.

For backend integration details, refer to `backend.md`. For day-by-day implementation steps, see the `steps/` directory.
