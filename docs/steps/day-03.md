# Day 3: Frontend & Integrations

## LearnForge — Tailwind v4, Alpine.js Islands & Polish

**Day**: 3 of 3  
**Duration**: 10-12 hours  
**Framework**: Blade + Tailwind CSS v4 + Alpine.js  
**Goal**: Build the V4 user interface, implement interactivity using Alpine.js islands, and finalize the application for local testing.

---

## 📋 Day 3 Overview

### Objectives

By end of Day 3, you will have:

- [ ] Main App Layout with Dark Mode & Command Palette
- [ ] Dashboard View with Stats & Heatmap
- [ ] Roadmap & Topic Interactive Views (Drag-drop, Trees)
- [ ] SRS Flashcard Flip UI
- [ ] Certificate generation & viewing UI
- [ ] Real-time Notifications (Pusher/Echo)
- [ ] Toast notification system

### Time Allocation

| Task                                 | Duration  |
| ------------------------------------ | --------- |
| App Shell & Global Components        | 2 hours   |
| Dashboard & Analytics View           | 1.5 hours |
| Roadmap & Topic Builders             | 3 hours   |
| SRS Flashcards & Interactive UI      | 2 hours   |
| Polishing & Polish (Confetti, Audio) | 1.5 hours |
| Final QA & Review                    | 1-2 hours |

---

## 🎨 Step 1: Global App Shell (2 hours)

### 1.1 Layout component

Update `layouts/app.blade.php`:

- Sidebar navigation integrating Badges, Streaks, XP.
- Inject Dark Mode toggle tied to `localStorage` via Alpine.js.
- Add `<x-toast />` component for global alerts.

### 1.2 Command Palette (Cmd+K)

Implement a global command palette component powered by Alpine.js that captures `Cmd+K` / `Ctrl+K`. It allows quick searching of roadmaps, adding tasks, and navigation.

### 1.3 Toast Notifications

Implement the Alpine-powered toast manager (see `frontend.md`) to handle success/error flashes dynamically on the client side without reloading.

---

## 📊 Step 2: Dashboard & Analytics (1.5 hours)

### 2.1 Analytics Dashboard

Create `resources/views/dashboard/index.blade.php`.
Fetch data from `DashboardController` and display:

- Total XP & current Level (Gamification).
- Current Streak & Longest Streak.
- `Chart.js` rendering for Topic completion burn-down.
- 52-week activity heatmap (similar to GitHub contributions).

---

## 🗺️ Step 3: Roadmaps & Topics (3 hours)

### 3.1 Roadmap Index & Filters

- Render roadmap cards (`<x-roadmap-card />`) with Alpine-driven client-side filtering (Active, Completed) and search.
- Display `progress-ring.blade.php` SVG component for progress.

### 3.2 Roadmap Show (Interactive Tree)

- Display phases and topics.
- Implement `SortableJS` using an Alpine wrapper to allow drag-and-drop reordering of topics.
- Inline topic status toggle: Alpine sends fetch request to `PATCH /api/v1/topics/{id}/status`. On success, trigger Confetti canvas.

### 3.3 Resource Uploader

- Implement file uploads using `FilePond` inside Alpine components for attaching PDFs/links to topics.

---

## 🧠 Step 4: SRS Flashcards UI (2 hours)

### 4.1 Flashcard Review Session

Create `resources/views/srs/review.blade.php`.

- The user reviews cards due today.
- Use 3D CSS transforms for the `<x-srs-card />` flip effect (see `frontend.md`).
- Buttons for (Again, Hard, Good, Easy) trigger AJAX requests to the `ReviewController`, recording SM-2 algorithm updates without page reload.

---

## ✨ Step 5: Real-time & Polish (1.5 hours)

### 5.1 Real-time Features

Initialize Laravel Echo with Pusher JS in `bootstrap.js`.

- Listen for `BadgeEarned` and `LevelUp` events on the private user channel.
- Trigger global toast or visual effects when an event is received.

### 5.2 Certificates

- `certificates/show.blade.php`: Use `@media print` CSS for perfect printing orientation (landscape). Include distinctive fonts (Georgia, Playfair) and a generated QR code linking to the verification URL.

### 5.3 Focus Mode (Optional integration)

- A "Pomodoro Session" UI overlay on topics.
- Play background noise using `Tone.js` (white noise) or an embedded lo-fi iframe.

---

## 🏁 Day 3 Wrap-up & Launch

- Run standard user flows: Create account -> Generate AI Roadmap -> Start Topic -> Log Time -> Review Flashcard -> Complete Roadmap -> View Certificate.
- Use Chrome DevTools (Lighthouse) to verify accessibility, mobile responsiveness, and Tailwind CSS purging optimization.
- Project is ready for production deployment (or further Laragon local development).

**End of 3-Day Implementation.**
