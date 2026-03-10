# Frontend Architecture Documentation
## LearnForge — Blade + Alpine.js + Tailwind CSS v4

**Version:** 4.0 (Windows + VSCode Edition)
**Last Updated:** March 2026
**Framework:** Laravel 12.x with Blade Templating
**Stack:** Blade Templates · Alpine.js 3.x · Tailwind CSS v4.x · HTML5

> **Frontend Rule:** Only **Alpine.js, HTML, and Tailwind CSS v4 in Blade files** are used for frontend. No Vue, No React, No SPA. All interactivity is handled via Alpine.js islands in Blade templates.

---

## Table of Contents

1. [Architecture Overview](#architecture-overview)
2. [Technology Stack](#technology-stack)
3. [Directory Structure](#directory-structure)
4. [Blade Templates](#blade-templates)
5. [Alpine.js Implementation](#alpinejs-implementation)
6. [Tailwind CSS v4 Setup](#tailwind-css-v4-setup)
7. [Color System & Dark Mode](#color-system--dark-mode)
8. [Component Library](#component-library)
9. [Real-Time with Pusher + Laravel Echo](#real-time-with-pusher--laravel-echo)
10. [Command Palette (Cmd+K)](#command-palette-cmdk)
11. [Animation System](#animation-system)
12. [Forms & Validation](#forms--validation)
13. [Responsive Design](#responsive-design)
14. [Accessibility](#accessibility)
15. [Performance Optimization](#performance-optimization)

---

## Architecture Overview

### Frontend Stack Philosophy

LearnForge uses a **hybrid SSR + Alpine.js islands** architecture:

- **Server-Side Rendering**: Blade templates for all primary page content — optimal for SEO and initial load
- **Islands Architecture**: Alpine.js for isolated interactive "islands" (modals, progress bars, drag-drop, charts, command palette) without hydrating the entire page
- **Progressive Enhancement**: Core functionality works without JavaScript; enhanced experience with it
- **Utility-First CSS**: Tailwind CSS v4 with CSS custom properties for theming

```
┌─────────────────────────────────────────────┐
│         Browser (Client Side)                │
│                                              │
│  ┌──────────────────────────────────────┐  │
│  │  Alpine.js (Islands of Reactivity)   │  │
│  │  - Modals, dropdowns, command palette│  │
│  │  - Progress bars, SRS card flip      │  │
│  │  - Dark mode toggle, toast system    │  │
│  │  - Drag-drop (+ SortableJS)          │  │
│  │  - Real-time via Pusher/Echo         │  │
│  └──────────────────────────────────────┘  │
│                                              │
│  ┌──────────────────────────────────────┐  │
│  │   Tailwind CSS v4 (Styling)          │  │
│  │  - CSS-first config via @import      │  │
│  │  - CSS custom properties for themes  │  │
│  │  - Dark mode via dark: variant       │  │
│  └──────────────────────────────────────┘  │
│                                              │
│  ┌──────────────────────────────────────┐  │
│  │   HTML (Blade Rendered, SSR)         │  │
│  │  - Semantic markup (article/section) │  │
│  │  - Schema.org JSON-LD injected       │  │
│  │  - SEO meta tags, OG tags            │  │
│  └──────────────────────────────────────┘  │
└─────────────────────────────────────────────┘
```

---

## Technology Stack

### Core (Required)

| Technology | Version | Purpose |
|-----------|---------|---------|
| **Blade** | Laravel 12.x | SSR templates, layouts, components |
| **Alpine.js** | 3.x | Client-side reactivity (15KB) |
| **Tailwind CSS** | 4.x | Utility-first CSS (CSS-first config) |

### Additional Libraries (CDN or npm)

| Library | Version | Purpose |
|---------|---------|---------|
| **Chart.js** | 4.x | Progress charts, analytics graphs, burn-down |
| **D3.js** | 7.x | Mind map SVG visualization |
| **SortableJS** | 1.x | Drag-and-drop topic reordering |
| **FilePond** | 4.x | Rich file upload with preview |
| **Tippy.js** | 6.x | Tooltips and popovers |
| **Day.js** | 1.x | Date formatting |
| **Prism.js** | 1.x | Code syntax highlighting (100+ languages) |
| **KaTeX** | 0.x | LaTeX math rendering in block editor |
| **Mermaid.js** | 10.x | Diagram blocks (flowchart, ER, Gantt, sequence) |
| **Excalidraw** | latest | Embedded whiteboard (iframe, MIT license) |
| **canvas-confetti** | 1.x | Celebration animation on topic/roadmap completion |
| **PDF.js** | 3.x | In-browser PDF viewer for file resources |
| **Tone.js** | latest | Focus mode background audio (lo-fi, white noise) |
| **YouTube IFrame API** | — | Embedded video player + timestamp control |
| **FingerprintJS CE** | latest | Device fingerprinting for security |
| **Pusher JS** | 8.x | WebSocket client |
| **Laravel Echo** | latest | WebSocket event listener wrapper |

```html
<!-- In layouts/app.blade.php head or @push('scripts') -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/prismjs@1/prism.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/prismjs@1/themes/prism-tomorrow.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/katex@0.16/dist/katex.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/katex@0.16/dist/katex.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9/dist/confetti.browser.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1.11/dayjs.min.js"></script>
```

---

## Directory Structure

```
resources/
├── views/
│   ├── layouts/
│   │   ├── app.blade.php              # Main app layout (sidebar + header)
│   │   ├── guest.blade.php            # Auth pages layout
│   │   ├── certificate.blade.php      # Certificate PDF layout
│   │   └── embed.blade.php            # Lightweight embed layout (no nav)
│   ├── components/
│   │   ├── button.blade.php
│   │   ├── card.blade.php
│   │   ├── input.blade.php
│   │   ├── modal.blade.php
│   │   ├── progress-bar.blade.php
│   │   ├── progress-ring.blade.php    # SVG circular progress
│   │   ├── roadmap-card.blade.php
│   │   ├── topic-item.blade.php
│   │   ├── resource-item.blade.php
│   │   ├── navbar.blade.php
│   │   ├── sidebar.blade.php
│   │   ├── alert.blade.php
│   │   ├── toast.blade.php            # Toast notification system
│   │   ├── command-palette.blade.php  # Cmd+K global command palette
│   │   ├── notification-bell.blade.php
│   │   ├── heatmap.blade.php          # 52-week activity heatmap
│   │   ├── srs-card.blade.php         # Flashcard flip component
│   │   ├── pomodoro-timer.blade.php
│   │   ├── skeleton.blade.php         # Skeleton loading screen
│   │   └── loading-spinner.blade.php
│   ├── auth/
│   │   ├── login.blade.php
│   │   ├── register.blade.php
│   │   ├── forgot-password.blade.php
│   │   ├── reset-password.blade.php
│   │   └── two-factor.blade.php       # 2FA TOTP challenge
│   ├── dashboard/
│   │   └── index.blade.php            # Main dashboard with stat cards + heatmap
│   ├── roadmaps/
│   │   ├── index.blade.php            # Roadmap list with filter/search
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   ├── show.blade.php             # Roadmap detail (list/kanban/timeline/mindmap)
│   │   └── public.blade.php           # Public read-only roadmap view
│   ├── topics/
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   ├── show.blade.php             # Topic detail with block editor
│   │   └── partials/
│   │       ├── topic-form.blade.php
│   │       ├── topic-list.blade.php
│   │       ├── kanban-view.blade.php
│   │       ├── timeline-view.blade.php
│   │       └── mindmap-view.blade.php
│   ├── resources/
│   │   ├── create.blade.php
│   │   ├── library.blade.php          # Global resource library
│   │   └── partials/
│   │       ├── resource-list.blade.php
│   │       └── file-viewer.blade.php  # PDF.js viewer
│   ├── certificates/
│   │   ├── index.blade.php
│   │   ├── show.blade.php
│   │   ├── verify.blade.php           # Public verification page
│   │   └── templates/
│   │       ├── modern.blade.php
│   │       ├── classic.blade.php
│   │       ├── minimalist.blade.php
│   │       ├── dark.blade.php
│   │       └── neon.blade.php
│   ├── analytics/
│   │   ├── index.blade.php            # Analytics hub
│   │   └── weekly.blade.php           # Weekly report card
│   ├── srs/
│   │   ├── index.blade.php            # SRS deck list
│   │   ├── review.blade.php           # Card review session
│   │   └── decks/
│   │       ├── create.blade.php
│   │       └── show.blade.php
│   ├── journal/
│   │   ├── index.blade.php            # Calendar-based journal
│   │   └── entry.blade.php            # Daily journal entry
│   ├── explore/
│   │   └── index.blade.php            # Community roadmap explorer
│   ├── profile/
│   │   ├── edit.blade.php             # Settings / profile edit
│   │   └── show.blade.php             # Public profile /u/{username}
│   ├── notifications/
│   │   └── index.blade.php
│   ├── achievements/
│   │   └── index.blade.php
│   ├── habits/
│   │   └── index.blade.php
│   ├── leaderboard/
│   │   └── index.blade.php
│   ├── search/
│   │   └── index.blade.php
│   ├── paths/
│   │   └── index.blade.php            # Learning path builder
│   ├── admin/
│   │   ├── dashboard.blade.php
│   │   ├── users/index.blade.php
│   │   └── moderation/index.blade.php
│   ├── changelog/
│   │   └── index.blade.php
│   └── welcome.blade.php
├── css/
│   └── app.css                        # Tailwind v4 entry (CSS-first config)
└── js/
    ├── app.js                         # Alpine.js + Echo bootstrap
    ├── bootstrap.js                   # Laravel + Pusher/Echo setup
    └── components/
        ├── charts.js
        ├── drag-drop.js
        ├── block-editor.js            # Block editor Alpine component
        └── srs-engine.js              # SM-2 client helpers
```

---

## Blade Templates

### Main Layout (layouts/app.blade.php)

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="appShell()"
      :class="{ 'dark': dark }"
      x-init="initTheme()">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LearnForge') }} — @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- Styles + Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- OG / SEO Meta -->
    @stack('meta')
    @stack('styles')
</head>
<body class="font-sans antialiased bg-(--color-bg) text-(--color-text-primary) transition-colors duration-200">

    <!-- Toast Container -->
    <x-toast />

    <!-- Command Palette -->
    <x-command-palette />

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <x-sidebar />

        <!-- Main area -->
        <div class="flex-1 flex flex-col lg:pl-64">
            <x-navbar />

            <main id="main-content" class="flex-1 px-4 sm:px-6 lg:px-8 py-8 max-w-7xl mx-auto w-full">
                @if(session('success'))
                    <x-alert type="success" :message="session('success')" />
                @endif
                @if(session('error'))
                    <x-alert type="error" :message="session('error')" />
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
```

---

## Alpine.js Implementation

### App Shell (Dark Mode + Keyboard Shortcuts)

```js
// resources/js/app.js
import Alpine from 'alpinejs'

Alpine.data('appShell', () => ({
    dark: false,
    commandPaletteOpen: false,

    initTheme() {
        // Respect system preference + user preference
        const stored = localStorage.getItem('theme');
        this.dark = stored === 'dark' ||
            (!stored && window.matchMedia('(prefers-color-scheme: dark)').matches);
    },

    toggleDark() {
        this.dark = !this.dark;
        localStorage.setItem('theme', this.dark ? 'dark' : 'light');
    },

    init() {
        // Global keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            // Cmd/Ctrl + K → Command Palette
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                this.commandPaletteOpen = !this.commandPaletteOpen;
            }
            // ? → Shortcuts overlay
            if (e.key === '?' && !e.target.matches('input, textarea')) {
                Alpine.store('ui').showShortcuts = true;
            }
        });
    }
}));

Alpine.start();
```

### Dashboard with Alpine Filtering

```blade
<div x-data="{
    filter: 'all',
    search: '',
    roadmaps: @js($roadmaps),
    get filtered() {
        return this.roadmaps.filter(r => {
            const matchFilter = this.filter === 'all' || r.status === this.filter;
            const matchSearch = !this.search ||
                r.title.toLowerCase().includes(this.search.toLowerCase());
            return matchFilter && matchSearch;
        });
    }
}">
    <!-- Filter pills -->
    <div class="flex gap-2 mb-6 flex-wrap">
        <template x-for="f in ['all', 'active', 'completed', 'archived']">
            <button @click="filter = f"
                :class="filter === f
                    ? 'bg-(--color-primary) text-white'
                    : 'bg-(--color-surface-2) text-(--color-text-secondary)'"
                class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors capitalize"
                x-text="f">
            </button>
        </template>
    </div>

    <!-- Search -->
    <input x-model="search" type="search" placeholder="Search roadmaps…"
        class="w-full input mb-6">

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <template x-for="roadmap in filtered" :key="roadmap.id">
            <x-roadmap-card :roadmap="roadmap" />
        </template>
    </div>

    <!-- Empty state -->
    <div x-show="filtered.length === 0" x-cloak
        class="text-center py-20 text-(--color-text-muted)">
        <p class="text-lg">No roadmaps found</p>
        <a href="{{ route('roadmaps.create') }}" class="btn btn-primary mt-4">Create your first roadmap</a>
    </div>
</div>
```

### Modal Component

```blade
{{-- resources/views/components/modal.blade.php --}}
@props(['name', 'show' => false, 'maxWidth' => '2xl'])

<div
    x-data="{ show: @js($show) }"
    x-on:open-modal.window="$event.detail === '{{ $name }}' && (show = true)"
    x-on:close-modal.window="$event.detail === '{{ $name }}' && (show = false)"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    role="dialog" aria-modal="true">

    <!-- Backdrop -->
    <div x-show="show"
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm"
        @click="show = false"></div>

    <!-- Panel -->
    <div x-show="show"
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-(--color-surface) rounded-2xl shadow-2xl w-full max-w-{{ $maxWidth }} z-10">
        {{ $slot }}
    </div>
</div>
```

### Topic Completion with Confetti

```blade
<div x-data="{
    status: '{{ $topic->status }}',
    async markComplete() {
        const res = await fetch('/topics/{{ $topic->id }}/status', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('[name=csrf-token]').content
            },
            body: JSON.stringify({ status: 'completed' })
        });
        if (res.ok) {
            this.status = 'completed';
            // 🎉 Confetti burst
            confetti({ particleCount: 100, spread: 70, origin: { y: 0.6 } });
            // Dispatch XP animation event
            window.dispatchEvent(new CustomEvent('xp-earned', { detail: { amount: 50 } }));
        }
    }
}">
    <button @click="markComplete()" x-show="status !== 'completed'"
        class="btn btn-primary flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        Mark Complete
    </button>
    <span x-show="status === 'completed'" class="inline-flex items-center gap-2 text-emerald-500 font-semibold">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
        </svg>
        Completed ✓
    </span>
</div>
```

---

## Tailwind CSS v4 Setup

### CSS Entry Point (resources/css/app.css)

> **Tailwind v4 uses CSS-first config** — no `tailwind.config.js` required.

```css
/* Tailwind v4 CSS-first import */
@import "tailwindcss";

/* Custom source detection (replaces content array in config) */
@source "../views/**/*.blade.php";
@source "../js/**/*.js";

/* ── Design Tokens (CSS Custom Properties) ── */
@layer base {
    :root {
        /* Primary Brand */
        --color-primary:       #6366F1;
        --color-primary-hover: #4F46E5;
        --color-primary-light: #EEF2FF;
        --color-primary-ring:  #C7D2FE;

        /* Semantic */
        --color-success:  #10B981;
        --color-warning:  #F59E0B;
        --color-error:    #EF4444;
        --color-info:     #3B82F6;

        /* Surfaces */
        --color-bg:        #F8FAFC;
        --color-surface:   #FFFFFF;
        --color-surface-2: #F1F5F9;
        --color-border:    #E2E8F0;
        --color-border-hover: #CBD5E1;

        /* Text */
        --color-text-primary:   #0F172A;
        --color-text-secondary: #475569;
        --color-text-muted:     #94A3B8;
        --color-text-disabled:  #CBD5E1;

        /* Typography */
        --font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        --font-mono: 'JetBrains Mono', 'Fira Code', monospace;
    }

    .dark {
        --color-bg:        #0A0A0F;
        --color-surface:   #13131A;
        --color-surface-2: #1C1C27;
        --color-border:    #2A2A3C;
        --color-border-hover: #3A3A52;

        --color-text-primary:   #F1F5F9;
        --color-text-secondary: #94A3B8;
        --color-text-muted:     #475569;

        --color-primary:       #818CF8;
        --color-primary-hover: #6366F1;
    }

    html { scroll-behavior: smooth; }
    body { font-family: var(--font-sans); }
    code, pre { font-family: var(--font-mono); }

    /* Reduced motion */
    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: 0.01ms !important;
            transition-duration: 0.01ms !important;
        }
    }
}

@layer components {
    /* Base button */
    .btn {
        @apply inline-flex items-center justify-center font-medium
               rounded-lg transition-all duration-150 focus:outline-none
               focus-visible:ring-2 focus-visible:ring-(--color-primary-ring)
               disabled:opacity-50 disabled:cursor-not-allowed;
    }
    .btn-primary {
        @apply px-4 py-2 bg-(--color-primary) text-white
               hover:bg-(--color-primary-hover) active:scale-95;
    }
    .btn-secondary {
        @apply px-4 py-2 bg-(--color-surface-2) text-(--color-text-primary)
               border border-(--color-border) hover:bg-(--color-border);
    }
    .btn-danger {
        @apply px-4 py-2 bg-red-500 text-white hover:bg-red-600 active:scale-95;
    }
    .btn-sm { @apply px-3 py-1.5 text-sm; }
    .btn-lg { @apply px-6 py-3 text-base; }

    /* Input */
    .input {
        @apply w-full px-3 py-2 rounded-lg border border-(--color-border)
               bg-(--color-surface) text-(--color-text-primary) text-sm
               focus:outline-none focus:ring-2 focus:ring-(--color-primary-ring)
               focus:border-(--color-primary) transition-colors
               placeholder:text-(--color-text-muted);
    }

    /* Card */
    .card {
        @apply bg-(--color-surface) rounded-2xl border border-(--color-border)
               shadow-sm hover:shadow-md transition-shadow duration-200;
    }

    /* Badge pill */
    .badge {
        @apply inline-flex items-center px-2.5 py-0.5 rounded-full
               text-xs font-medium;
    }
    .badge-primary { @apply bg-(--color-primary-light) text-(--color-primary); }
    .badge-success { @apply bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400; }
    .badge-warning { @apply bg-amber-100 text-amber-800; }
    .badge-error   { @apply bg-red-100 text-red-800; }

    /* Progress bar */
    .progress-bar {
        @apply w-full h-2 bg-(--color-surface-2) rounded-full overflow-hidden;
    }
    .progress-fill {
        @apply h-full bg-(--color-primary) rounded-full transition-all duration-700 ease-out;
    }

    /* Skeleton */
    .skeleton {
        @apply bg-(--color-surface-2) rounded animate-pulse;
    }
}
```

### vite.config.js

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

---

## Color System & Dark Mode

| Token | Light | Dark |
|-------|-------|------|
| `--color-primary` | `#6366F1` | `#818CF8` |
| `--color-bg` | `#F8FAFC` | `#0A0A0F` |
| `--color-surface` | `#FFFFFF` | `#13131A` |
| `--color-surface-2` | `#F1F5F9` | `#1C1C27` |
| `--color-border` | `#E2E8F0` | `#2A2A3C` |
| `--color-text-primary` | `#0F172A` | `#F1F5F9` |
| `--color-text-secondary` | `#475569` | `#94A3B8` |

**Dark mode toggle (Alpine.js):**
```blade
<button @click="toggleDark()" class="btn btn-secondary btn-sm" aria-label="Toggle dark mode">
    <svg x-show="!dark" class="w-4 h-4" ...><!-- moon icon --></svg>
    <svg x-show="dark" class="w-4 h-4" ...><!-- sun icon --></svg>
</button>
```

---

## Component Library

### Progress Ring (SVG)

```blade
{{-- resources/views/components/progress-ring.blade.php --}}
@props(['percentage' => 0, 'size' => 80, 'stroke' => 6])

@php
$radius = ($size - $stroke) / 2;
$circumference = 2 * M_PI * $radius;
$offset = $circumference - ($percentage / 100) * $circumference;
@endphp

<svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 {{ $size }} {{ $size }}"
     role="progressbar" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"
     aria-label="{{ $percentage }}% complete">
    <circle cx="{{ $size/2 }}" cy="{{ $size/2 }}" r="{{ $radius }}"
        fill="none" stroke="var(--color-surface-2)" stroke-width="{{ $stroke }}"/>
    <circle cx="{{ $size/2 }}" cy="{{ $size/2 }}" r="{{ $radius }}"
        fill="none" stroke="var(--color-primary)" stroke-width="{{ $stroke }}"
        stroke-linecap="round"
        stroke-dasharray="{{ $circumference }}"
        stroke-dashoffset="{{ $offset }}"
        transform="rotate(-90 {{ $size/2 }} {{ $size/2 }})"
        style="transition: stroke-dashoffset 0.7s ease-out"/>
    <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle"
        class="text-sm font-bold fill-current">{{ $percentage }}%</text>
</svg>
```

### Toast Notification System

```blade
{{-- resources/views/components/toast.blade.php --}}
<div x-data="toastManager()" x-on:toast.window="add($event.detail)"
     class="fixed top-4 right-4 z-[9999] space-y-2 max-w-sm w-full" aria-live="polite">
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.show"
             x-transition:enter="transform ease-out duration-300"
             x-transition:enter-start="translate-x-full opacity-0"
             x-transition:enter-end="translate-x-0 opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             :class="{
                 'border-emerald-500 bg-emerald-50 dark:bg-emerald-900/20': toast.type === 'success',
                 'border-red-500 bg-red-50 dark:bg-red-900/20': toast.type === 'error',
                 'border-amber-500 bg-amber-50 dark:bg-amber-900/20': toast.type === 'warning',
                 'border-blue-500 bg-blue-50 dark:bg-blue-900/20': toast.type === 'info',
             }"
             class="card border-l-4 p-4 flex items-start gap-3 shadow-lg">
            <p x-text="toast.message" class="text-sm flex-1"></p>
            <button @click="remove(toast.id)" class="text-(--color-text-muted) hover:text-(--color-text-primary)">✕</button>
        </div>
    </template>
</div>

@push('scripts')
<script>
function toastManager() {
    return {
        toasts: [],
        add({ message, type = 'info', duration = 4000 }) {
            const id = Date.now();
            this.toasts.push({ id, message, type, show: true });
            setTimeout(() => this.remove(id), duration);
        },
        remove(id) {
            const t = this.toasts.find(t => t.id === id);
            if (t) t.show = false;
            setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 300);
        }
    };
}
// Helper: window.toast('message', 'success')
window.toast = (message, type = 'info') =>
    window.dispatchEvent(new CustomEvent('toast', { detail: { message, type } }));
</script>
@endpush
```

### SRS Card Flip

```blade
{{-- resources/views/components/srs-card.blade.php --}}
@props(['card'])
<div x-data="{ flipped: false, rating: null }" class="perspective-1000">
    <div :class="flipped && 'rotate-y-180'" class="relative w-full h-64 transition-transform duration-500 transform-style-preserve-3d cursor-pointer"
         @click="!flipped && (flipped = true)" @keydown.space.prevent="!flipped && (flipped = true)">

        <!-- Front -->
        <div class="card absolute inset-0 flex items-center justify-center p-8 backface-hidden">
            <p class="text-xl text-center font-medium">{{ $card->front }}</p>
        </div>

        <!-- Back -->
        <div class="card absolute inset-0 flex flex-col items-center justify-between p-8 backface-hidden rotate-y-180">
            <p class="text-lg text-center">{{ $card->back }}</p>
            <div class="flex gap-3 mt-4">
                @foreach(['Again' => 1, 'Hard' => 2, 'Good' => 3, 'Easy' => 4] as $label => $value)
                <button @click.stop="rating = {{ $value }}" wire:click="rate({{ $card->id }}, {{ $value }})"
                    class="btn btn-sm {{ $loop->first ? 'btn-danger' : ($loop->last ? 'btn-primary' : 'btn-secondary') }}">
                    {{ $label }}
                </button>
                @endforeach
            </div>
        </div>
    </div>
</div>
```

---

## Real-Time with Pusher + Laravel Echo

### Bootstrap (resources/js/bootstrap.js)

```js
import { default as axios } from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});
```

### Notification Bell (Alpine.js + Echo)

```blade
{{-- components/notification-bell.blade.php --}}
<div x-data="notificationBell()" x-init="listen()" class="relative">
    <button @click="open = !open" class="relative p-2 rounded-lg hover:bg-(--color-surface-2)"
            aria-label="Notifications">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        <span x-show="unread > 0" x-text="unread"
            class="absolute -top-1 -right-1 min-w-[1.125rem] h-[1.125rem] rounded-full bg-red-500 text-white text-[10px] font-bold flex items-center justify-center animate-pulse">
        </span>
    </button>
</div>

@push('scripts')
<script>
function notificationBell() {
    return {
        open: false,
        unread: {{ auth()->user()->unreadNotifications()->count() }},
        notifications: [],

        listen() {
            window.Echo.private(`user.{{ auth()->id() }}`)
                .listen('.notification.new', (data) => {
                    this.unread++;
                    this.notifications.unshift(data.notification);
                    window.toast(data.notification.message, 'info');
                });
        }
    };
}
</script>
@endpush
```

---

## Command Palette (Cmd+K)

```blade
{{-- components/command-palette.blade.php --}}
<div x-show="commandPaletteOpen" x-cloak
     class="fixed inset-0 z-[9998] flex items-start justify-center pt-20 px-4">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="commandPaletteOpen = false"></div>

    <div class="relative w-full max-w-xl bg-(--color-surface) rounded-2xl shadow-2xl border border-(--color-border) overflow-hidden"
         x-transition:enter="ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">

        <!-- Search input -->
        <div class="flex items-center gap-3 px-4 py-4 border-b border-(--color-border)">
            <svg class="w-4 h-4 text-(--color-text-muted)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" x-model="paletteQuery" @keydown.escape="commandPaletteOpen = false"
                placeholder="Search or type a command…"
                class="flex-1 bg-transparent text-(--color-text-primary) placeholder:text-(--color-text-muted) focus:outline-none text-sm"
                x-ref="paletteInput" x-effect="commandPaletteOpen && $nextTick(() => $refs.paletteInput.focus())">
            <kbd class="text-[10px] bg-(--color-surface-2) border border-(--color-border) px-1.5 py-0.5 rounded font-mono text-(--color-text-muted)">ESC</kbd>
        </div>

        <!-- Results -->
        <div class="max-h-80 overflow-y-auto p-2 divide-y divide-(--color-border)">
            <!-- Navigation -->
            <div class="pb-2">
                <p class="px-3 py-1 text-[10px] font-semibold uppercase tracking-wider text-(--color-text-muted)">Navigation</p>
                @foreach([
                    ['Dashboard', '/dashboard', 'g d'],
                    ['Explore', '/explore', 'g e'],
                    ['Review SRS', '/review', 'g r'],
                    ['Journal', '/journal', 'g j'],
                    ['Analytics', '/analytics', 'g a'],
                ] as [$label, $href, $shortcut])
                <a href="{{ $href }}" @click="commandPaletteOpen = false"
                   class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-(--color-surface-2) text-sm transition-colors">
                    <span>{{ $label }}</span>
                    <kbd class="text-[10px] bg-(--color-surface-2) px-1.5 py-0.5 rounded font-mono text-(--color-text-muted)">{{ $shortcut }}</kbd>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
```

---

## Animation System

```css
/* In app.css — @layer utilities */
@layer utilities {
    /* Duration tokens */
    .duration-instant { transition-duration: 50ms; }
    .duration-fast    { transition-duration: 150ms; }
    .duration-normal  { transition-duration: 250ms; }
    .duration-slow    { transition-duration: 400ms; }

    /* 3D card flip (SRS cards) */
    .perspective-1000 { perspective: 1000px; }
    .transform-style-preserve-3d { transform-style: preserve-3d; }
    .backface-hidden { backface-visibility: hidden; }
    .rotate-y-180 { transform: rotateY(180deg); }
}

/* XP burst animation */
@keyframes xp-float {
    0%   { opacity: 1; transform: translateY(0) scale(1); }
    100% { opacity: 0; transform: translateY(-60px) scale(1.2); }
}
.xp-burst { animation: xp-float 1.5s ease-out forwards; }

/* Streak flame flicker */
@keyframes flame {
    0%, 100% { transform: scale(1); }
    50%       { transform: scale(1.05) rotate(2deg); }
}
.streak-flame { animation: flame 2s ease-in-out infinite; }
```

---

## Forms & Validation

```blade
{{-- resources/views/components/input.blade.php --}}
@props(['label', 'name', 'error' => null, 'type' => 'text', 'hint' => null])

<div class="space-y-1.5">
    @if(isset($label))
    <label for="{{ $name }}" class="block text-sm font-medium text-(--color-text-secondary)">
        {{ $label }}
    </label>
    @endif

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        {{ $attributes->class(['input', 'border-red-500 focus:ring-red-300' => $error]) }}
        @if($error) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif>

    @if($hint && !$error)
        <p class="text-xs text-(--color-text-muted)">{{ $hint }}</p>
    @endif

    @if($error)
        <p id="{{ $name }}-error" class="text-xs text-red-500" role="alert">{{ $error }}</p>
    @endif
</div>
```

---

## Responsive Design

- **Mobile-first**: Base styles target mobile; `sm:`, `md:`, `lg:`, `xl:` for progressive enhancement
- **Sidebar**: Hidden on mobile, fixed on `lg:`; toggle via Alpine.js `sidebarOpen` state
- **Bottom Nav (mobile)**: 5-tab navigation visible only on small screens (`lg:hidden`)
- **Touch targets**: All interactive elements minimum 44×44px
- **SRS swipe gestures**: Swipe up = Good, swipe down = Again (Alpine.js + Touch events)

```blade
<!-- Mobile bottom navigation -->
<nav class="fixed bottom-0 inset-x-0 bg-(--color-surface) border-t border-(--color-border)
            lg:hidden flex items-center justify-around h-16 z-40">
    @foreach([
        ['Home', '/dashboard', 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['Explore', '/explore', 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
        ['Review', '/review', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['Journal', '/journal', 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
        ['Profile', '/profile', 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
    ] as [$label, $href, $icon])
    <a href="{{ $href }}" class="flex flex-col items-center gap-1 text-xs
        {{ request()->is(ltrim($href, '/') . '*') ? 'text-(--color-primary)' : 'text-(--color-text-muted)' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
        </svg>
        {{ $label }}
    </a>
    @endforeach
</nav>
```

---

## Accessibility

- All interactive elements have `aria-label`, `role`, and keyboard focus styles
- Progress bars include `aria-valuenow`, `aria-valuemin`, `aria-valuemax`, `aria-valuetext`
- Toast notifications use `aria-live="polite"` (info/success) and `role="alert"` (error)
- Modals trap focus; `Escape` closes; focus returns to opener on close
- All form errors linked to inputs via `aria-describedby`
- Charts include `<table>` data alternatives in `<details>` (visually hidden)
- Skip navigation link: `<a href="#main-content" class="sr-only focus:not-sr-only">Skip to content</a>`
- Drag-and-drop has `Shift+Arrow` keyboard alternative

---

## Performance Optimization

- **Blade view caching** in production: `php artisan view:cache`
- **Vite asset fingerprinting**: automatic cache-busting
- **CDN libraries**: Loaded only on pages that need them via `@push('scripts')`
- **Alpine.js**: 15KB — no build step required; instantiate only needed components per page
- **Images**: WebP format, `loading="lazy"`, explicit `width`/`height` to prevent CLS
- **Tailwind v4**: Zero-runtime CSS; only used classes included via `@source` scanning
- **Font subsetting**: Google Fonts with `display=swap` to prevent FOIT

---

*LearnForge Frontend v4.0 — Alpine.js + HTML + Tailwind CSS v4 in Blade. No Vue. No React.*
