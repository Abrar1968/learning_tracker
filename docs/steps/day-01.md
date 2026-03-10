# Day 1: Foundation & Scaffold

## LearnForge — Local Environment & Core Scaffold

**Day**: 1 of 3  
**Duration**: 8-10 hours  
**Framework**: Laravel 12.x  
**Goal**: Complete environment setup (Windows Laragon), Laravel 12 foundation, Authentication, and complete Database Migration setup for the 66 tables.

---

## 📋 Day 1 Overview

### Objectives

By end of Day 1, you will have:

- [ ] Laragon Full (Windows) optimized with PHP 8.3+, MySQL 8, Redis
- [ ] Laravel 12.x project initialized
- [ ] Authentication system (Laravel Breeze + Sanctum + Socialite prep)
- [ ] Tailwind CSS v4 + Alpine.js base integration
- [ ] All 66 Database Migrations generated and run
- [ ] Core Models established with traits

### Time Allocation

| Task                                   | Duration  |
| -------------------------------------- | --------- |
| System Setup (Laragon, Composer, Node) | 1 hour    |
| Laravel 12 Installation & Config       | 1 hour    |
| Authentication (Breeze + 2FA prep)     | 1.5 hours |
| Frontend Shell (Tailwind v4 / Alpine)  | 1.5 hours |
| Database Migrations (All 66 Tables)    | 3-4 hours |

---

## 🔧 Prerequisites (Windows + VSCode Edition)

### Required Software

- **Laragon Full**: For Nginx, MySQL 8.0+, PHP 8.3+, Redis 5+
- **Composer 2.6+** and **Node.js 20+** (NPM 10+)
- **GitBash / Windows Terminal**
- **VSCode** with extensions: PHP Intelephense, Laravel Blade Snippets, Tailwind CSS IntelliSense, Alpine.js IntelliSense.

---

## 📦 Step 1: Environment & Laravel 12 Setup (2 hours)

### 1.1 Create New Laravel 12 Project

Using Laragon terminal:

```bash
cd C:\laragon\www
composer create-project laravel/laravel learnforge
cd learnforge
```

### 1.2 Configuration (.env)

Set up database and Redis caching for the V4 architecture.

```env
APP_NAME=LearnForge
APP_KEY=base64:...
APP_ENV=local
APP_DEBUG=true
APP_URL=http://learnforge.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=learnforge
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 1.3 Authentication Scaffolding

Laravel 12 + Breeze for base auth.

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run dev
```

Update `User` model to support Gamification, Streak, SRS attributes per V4 spec.

---

## 💅 Step 2: Frontend Shell Setup (1.5 hours)

### 2.1 Tailwind CSS v4 Integration

Tailwind v4 uses CSS-first configuration. Edit `resources/css/app.css`:

```css
@import "tailwindcss";

@source "../views/**/*.blade.php";
@source "../js/**/*.js";

@layer base {
    :root {
        --color-bg: #f8fafc;
        --color-surface: #ffffff;
        --color-primary: #6366f1;
        /* Add variables from frontend.md */
    }
    .dark {
        --color-bg: #0a0a0f;
        --color-surface: #13131a;
        /* Add dark mode variables */
    }
}
```

### 2.2 Alpine.js Initialization

In `resources/js/app.js`:

```javascript
import Alpine from "alpinejs";

document.addEventListener("alpine:init", () => {
    Alpine.data("appShell", () => ({
        dark: false,
        commandPaletteOpen: false,
        initTheme() {
            /* LocalStorage / Prefers Color Scheme logic */
        },
        toggleDark() {
            /* Toggle Logic */
        },
    }));
});

window.Alpine = Alpine;
Alpine.start();
```

---

## 🗄️ Step 3: Database Scaffold — The 66 Tables (4 hours)

The V4 architecture expands to 66 tables. Create migrations systematically to respect foreign key constraints.

### 3.1 Create Core Migrations

```bash
# Users & Auth (Already handled mostly by Breeze)
php artisan make:migration create_user_providers_table

# Roadmaps & Topics
php artisan make:migration create_roadmaps_table
php artisan make:migration create_roadmap_phases_table
php artisan make:migration create_topics_table
php artisan make:migration create_topic_dependencies_table

# Resources & Certificates
php artisan make:migration create_resources_table
php artisan make:migration create_certificates_table

# SRS Flashcards
php artisan make:migration create_flashcard_decks_table
php artisan make:migration create_flashcards_table
php artisan make:migration create_flashcard_reviews_table

# Gamification & Social
php artisan make:migration create_xp_transactions_table
php artisan make:migration create_badges_table
php artisan make:migration create_user_badges_table
php artisan make:migration create_streaks_table
php artisan make:migration create_follows_table

# Productivity & Journal
php artisan make:migration create_journal_entries_table
php artisan make:migration create_habits_table
php artisan make:migration create_pomodoro_sessions_table
```

_(See `database.md` for full schema definition of all 66 tables and correct migration order)._

### 3.2 Execute Migration & Validate

```bash
php artisan migrate:fresh --seed
```

Verify via TablePlus / HeidiSQL that the schema is created using `utf8mb4_unicode_ci` and InnoDB.

---

## 🏁 Day 1 Wrap-up

- Validate the local app on `http://learnforge.test`
- Verify user registration works.
- Verify 66 tables exist in MySQL.
- Commit initial state: `git commit -m "Day 1: Base install, Breeze auth, 66 tables scaffold"`
