# Database Schema Documentation
## LearnForge — Complete Database Design

**Version:** 4.0 (Windows + VSCode Edition)
**Last Updated:** March 2026
**Framework:** Laravel 12.x
**Database:** MySQL 8.0+
**ORM:** Eloquent
**Character Set:** utf8mb4_unicode_ci (full Unicode + emoji)

---

## Table of Contents

1. [Database Overview](#database-overview)
2. [All 66 Tables](#all-66-tables)
3. [Core Table Specifications](#core-table-specifications)
4. [Entity Relationship Overview](#entity-relationship-overview)
5. [Migration Order](#migration-order)
6. [Key Indexes & Performance](#key-indexes--performance)
7. [Caching Strategy](#caching-strategy)
8. [Backup & Maintenance (Windows)](#backup--maintenance-windows)

---

## Database Overview

The LearnForge platform uses **MySQL 8.0+** with:

- **66 Tables** across 12 functional domains
- **Character Set**: utf8mb4_unicode_ci (full Unicode + emoji)
- **Engine**: InnoDB (ACID compliance, foreign key support)
- **Redis**: Cache layer, sessions, queues, rate limiting
- **TNTSearch**: Full-text search (pure PHP, via Laravel Scout)

### Functional Domains

| Domain | Table Count | Key Tables |
|--------|------------|------------|
| Authentication & Users | 5 | users, user_providers, sessions, password_reset_tokens |
| Roadmaps & Topics | 6 | roadmaps, roadmap_phases, topics, topic_dependencies, topic_time_logs, topic_reflections |
| Resources | 2 | resources, resource_tags |
| Certificates | 2 | certificates, certificate_portfolios |
| SRS / Flashcards | 3 | flashcard_decks, flashcards, flashcard_reviews |
| Gamification | 5 | xp_transactions, badges, user_badges, streaks, daily_challenges |
| Social & Community | 8 | follows, roadmap_ratings, roadmap_reviews, roadmap_comments, roadmap_bookmarks, roadmap_collaborators, study_buddy_pairs, mentorship_requests |
| Journal & Mood | 2 | journal_entries, mood_logs |
| Productivity | 3 | habits, habit_logs, pomodoro_sessions |
| Analytics & Tracking | 3 | activity_logs, user_login_history, weekly_reports |
| Integrations & API | 4 | webhooks, webhook_deliveries, integrations, push_subscriptions |
| Content & Admin | 7 | notifications, learning_paths, learning_path_items, changelog_entries, user_skills, feature_flags, reports |

---

## All 66 Tables

```
Authentication & Users (5)
  1.  users
  2.  user_providers           (OAuth: Google, GitHub, LinkedIn)
  3.  sessions
  4.  password_reset_tokens
  5.  personal_access_tokens   (Sanctum API tokens)

Roadmaps & Topics (6)
  6.  roadmaps
  7.  roadmap_phases
  8.  topics
  9.  topic_dependencies
  10. topic_time_logs
  11. topic_reflections

Resources (2)
  12. resources
  13. resource_tags

Certificates (2)
  14. certificates
  15. certificate_portfolios

SRS / Flashcards (3)
  16. flashcard_decks
  17. flashcards
  18. flashcard_reviews

Gamification (5)
  19. xp_transactions
  20. badges
  21. user_badges
  22. streaks
  23. daily_challenges

Social & Community (8)
  24. follows
  25. roadmap_ratings
  26. roadmap_reviews
  27. roadmap_comments
  28. roadmap_bookmarks
  29. roadmap_collaborators
  30. study_buddy_pairs
  31. mentorship_requests

Journal & Mood (2)
  32. journal_entries
  33. mood_logs

Productivity (3)
  34. habits
  35. habit_logs
  36. pomodoro_sessions

Analytics & Tracking (3)
  37. activity_logs
  38. user_login_history
  39. weekly_reports

Integrations & API (4)
  40. webhooks
  41. webhook_deliveries
  42. integrations
  43. push_subscriptions

Content & Admin (7)
  44. notifications
  45. learning_paths
  46. learning_path_items
  47. changelog_entries
  48. user_skills
  49. feature_flags
  50. reports

Laravel Framework Tables (16)
  51. jobs
  52. failed_jobs
  53. job_batches
  54. cache
  55. cache_locks
  56. telescope_entries
  57. telescope_entries_tags
  58. telescope_monitoring
  59. horizon_jobs
  60. horizon_metrics
  61. horizon_processes
  62. horizon_supervisors
  63. search_index (TNTSearch)
  64. scout_full_text_search
  65. media               (Spatie MediaLibrary)
  66. role_has_permissions (Spatie Permission)
```

---

## Core Table Specifications

### 1. users

**Purpose**: User accounts with full v4 profile fields

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| username | VARCHAR(30) | UNIQUE, NOT NULL | Username (3–30 chars) |
| email | VARCHAR(255) | UNIQUE, NOT NULL | Email address |
| password | VARCHAR(255) | NULLABLE | Null for OAuth-only users |
| full_name | VARCHAR(100) | NULL | Display name |
| headline | VARCHAR(150) | NULL | "Senior Dev at Acme" |
| profession | VARCHAR(100) | NULL | Profession/job title |
| bio | TEXT | NULL | Markdown bio |
| location | VARCHAR(100) | NULL | City, Country |
| website | VARCHAR(255) | NULL | Personal URL |
| github_username | VARCHAR(50) | NULL | For Gist backup + linking |
| linkedin_url | VARCHAR(255) | NULL | LinkedIn profile URL |
| twitter_username | VARCHAR(50) | NULL | Twitter/X handle |
| profile_picture | VARCHAR(500) | NULL | Avatar path |
| cover_image | VARCHAR(500) | NULL | Profile banner image |
| timezone | VARCHAR(60) | DEFAULT 'UTC' | User IANA timezone |
| locale | VARCHAR(10) | DEFAULT 'en' | Language preference |
| theme | ENUM | DEFAULT 'system' | light/dark/system |
| accent_color | VARCHAR(20) | DEFAULT '#6366F1' | Custom accent hex |
| available_hours_week | DECIMAL(4,1) | DEFAULT 10 | Weekly study hours |
| is_mentor | BOOLEAN | DEFAULT FALSE | Listed as mentor |
| is_public | BOOLEAN | DEFAULT FALSE | Public profile |
| two_factor_secret | VARCHAR(255) | NULL | Encrypted TOTP secret |
| two_factor_confirmed | BOOLEAN | DEFAULT FALSE | 2FA is active |
| onboarding_completed | BOOLEAN | DEFAULT FALSE | Onboarding finished |
| last_active_at | TIMESTAMP | NULL | Last activity |
| email_verified_at | TIMESTAMP | NULL | Verification time |
| remember_token | VARCHAR(100) | NULL | Remember me token |
| created_at | TIMESTAMP | NOT NULL | Account created |
| updated_at | TIMESTAMP | NOT NULL | Last updated |
| deleted_at | TIMESTAMP | NULL | Soft delete |

**Key Indexes**:
```sql
UNIQUE KEY (username)
UNIQUE KEY (email)
INDEX (is_public, is_mentor)
INDEX (last_active_at)
```

---

### 6. roadmaps

**Purpose**: Learning plans — v4 with composite scoring, visibility, clone tracking

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| user_id | BIGINT UNSIGNED | FK, NOT NULL | Owner |
| title | VARCHAR(255) | NOT NULL | Roadmap title |
| slug | VARCHAR(280) | UNIQUE, NOT NULL | URL slug |
| description | TEXT | NULL | Full description |
| category | VARCHAR(100) | NULL | Category |
| cover_image | VARCHAR(500) | NULL | Unsplash or uploaded image |
| difficulty_level | ENUM | NULL | beginner/intermediate/advanced |
| tags | JSON | NULL | `["php", "laravel"]` |
| target_completion_date | DATE | NULL | Target date |
| is_public | BOOLEAN | DEFAULT FALSE | Listed publicly |
| visibility | ENUM | DEFAULT 'private' | private/link/public |
| status | ENUM | DEFAULT 'active' | draft/active/completed/archived |
| progress_percentage | DECIMAL(5,2) | DEFAULT 0 | Simple % complete |
| weighted_progress | DECIMAL(5,2) | DEFAULT 0 | Weight-based progress |
| quality_score | DECIMAL(5,2) | DEFAULT 0 | Avg quality of topics |
| composite_score | DECIMAL(5,2) | DEFAULT 0 | (40% completion + 30% weight + 15% time + 15% quality) |
| cloned_from_id | BIGINT UNSIGNED | FK, NULL | Source roadmap |
| total_clones | INT UNSIGNED | DEFAULT 0 | Times cloned |
| total_views | INT UNSIGNED | DEFAULT 0 | Public view count |
| total_bookmarks | INT UNSIGNED | DEFAULT 0 | Bookmark count |
| average_rating | DECIMAL(3,2) | DEFAULT 0 | Community rating |
| ratings_count | INT UNSIGNED | DEFAULT 0 | Number of raters |
| created_at | TIMESTAMP | NOT NULL | — |
| updated_at | TIMESTAMP | NOT NULL | — |
| deleted_at | TIMESTAMP | NULL | Soft delete |

**Key Indexes**:
```sql
UNIQUE KEY (slug)
INDEX (user_id, status, updated_at)
INDEX (is_public, status, composite_score DESC)
INDEX (category, is_public)
FULLTEXT (title, description)  -- For TNTSearch compatibility
```

---

### 7. roadmap_phases

**Purpose**: Named groupings of topics within a roadmap (Phase 1: Fundamentals, etc.)

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK | — |
| roadmap_id | BIGINT UNSIGNED | FK, NOT NULL | — |
| title | VARCHAR(255) | NOT NULL | Phase name |
| description | TEXT | NULL | Phase description |
| order_index | INTEGER | DEFAULT 0 | Display order |
| created_at | TIMESTAMP | — | — |
| updated_at | TIMESTAMP | — | — |

---

### 8. topics

**Purpose**: Individual learning units — v4 with scheduling, priority, confidence

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | — |
| roadmap_id | BIGINT UNSIGNED | FK, NOT NULL | Parent roadmap |
| phase_id | BIGINT UNSIGNED | FK, NULL | Optional phase group |
| parent_topic_id | BIGINT UNSIGNED | FK, NULL | Sub-topic parent |
| title | VARCHAR(255) | NOT NULL | Topic title |
| description | TEXT | NULL | Rich Markdown description |
| estimated_hours | DECIMAL(6,2) | NOT NULL | Planned learning time |
| actual_hours | DECIMAL(6,2) | DEFAULT 0 | Total logged time |
| difficulty_level | ENUM | NULL | beginner/intermediate/advanced |
| priority | TINYINT | DEFAULT 2 | 1=Low 2=Normal 3=High |
| order_index | INTEGER | DEFAULT 0 | Display order in list |
| weight | INTEGER | DEFAULT 1 | Scoring weight (1–10) |
| status | ENUM | DEFAULT 'not_started' | not_started/in_progress/completed/skipped/on_hold |
| quality_rating | TINYINT | NULL | Self-rating 1–5 |
| confidence_level | TINYINT | NULL | Confidence 1–5 |
| started_at | TIMESTAMP | NULL | — |
| completed_at | TIMESTAMP | NULL | — |
| scheduled_date | DATE | NULL | Planned study date |
| due_date | DATE | NULL | Deadline |
| created_at | TIMESTAMP | NOT NULL | — |
| updated_at | TIMESTAMP | NOT NULL | — |

**Key Indexes**:
```sql
INDEX (roadmap_id, order_index)
INDEX (roadmap_id, status)
INDEX (due_date, status)        -- For "overdue" queries
INDEX (parent_topic_id)
```

---

### 12. resources

**Purpose**: Study materials attached to topics — v4 with OG meta, language, timestamps

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK | — |
| topic_id | BIGINT UNSIGNED | FK, NOT NULL | Parent topic |
| resource_type | ENUM | NOT NULL | file/link/note/video/voice/code/embed |
| title | VARCHAR(255) | NOT NULL | Display title |
| description | TEXT | NULL | Description |
| content | LONGTEXT | NULL | Block editor JSON |
| file_path | VARCHAR(500) | NULL | Storage path (private) |
| file_size | BIGINT | NULL | Bytes |
| mime_type | VARCHAR(100) | NULL | Detected MIME type |
| url | VARCHAR(2048) | NULL | External URL |
| og_title | VARCHAR(255) | NULL | Link preview title |
| og_description | TEXT | NULL | Link preview description |
| og_image | VARCHAR(500) | NULL | Link preview image |
| og_domain | VARCHAR(255) | NULL | e.g., "youtube.com" |
| language | VARCHAR(20) | NULL | Code/content language |
| duration_sec | INTEGER | NULL | Video/audio duration |
| is_favorite | BOOLEAN | DEFAULT FALSE | — |
| is_completed | BOOLEAN | DEFAULT FALSE | Resource consumed |
| order_index | INTEGER | DEFAULT 0 | — |
| created_at | TIMESTAMP | — | — |
| updated_at | TIMESTAMP | — | — |

---

### 14. certificates

**Purpose**: Completion certificates with blockchain fingerprint and extended metadata

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK | — |
| uuid | CHAR(36) | UNIQUE, NOT NULL | Verification UUID |
| user_id | BIGINT UNSIGNED | FK, NOT NULL | — |
| roadmap_id | BIGINT UNSIGNED | FK, NOT NULL | — |
| certificate_number | VARCHAR(20) | UNIQUE | LF-YYYY-XXXXXXXX format |
| issued_at | TIMESTAMP | NOT NULL | — |
| total_topics | INTEGER | NOT NULL | Topics completed |
| total_learning_hours | DECIMAL(8,2) | NOT NULL | Total hours |
| composite_score | DECIMAL(5,2) | NOT NULL | Final composite score |
| topics_summary | JSON | NOT NULL | Array of completed topics |
| template_type | VARCHAR(50) | DEFAULT 'modern' | modern/classic/minimalist/dark/neon |
| template_data | JSON | NULL | Custom colors, fonts |
| sha256_hash | VARCHAR(64) | NOT NULL | Content hash for verification |
| blockchain_tx | VARCHAR(255) | NULL | Optional blockchain anchor |
| file_path | VARCHAR(500) | NULL | Stored PDF path |
| verification_url | VARCHAR(500) | NOT NULL | Public verify URL |
| linkedin_post_id | VARCHAR(100) | NULL | LinkedIn share tracking |
| is_revoked | BOOLEAN | DEFAULT FALSE | Revoked status |
| revoked_at | TIMESTAMP | NULL | — |
| revoked_reason | TEXT | NULL | — |
| created_at | TIMESTAMP | — | — |
| updated_at | TIMESTAMP | — | — |

---

### 16. flashcard_decks

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK | — |
| user_id | BIGINT UNSIGNED | FK, NOT NULL | Owner |
| topic_id | BIGINT UNSIGNED | FK, NULL | Linked topic (optional) |
| title | VARCHAR(255) | NOT NULL | Deck name |
| description | TEXT | NULL | — |
| card_count | INTEGER | DEFAULT 0 | Cached count |
| due_count | INTEGER | DEFAULT 0 | Cards due today (cached) |
| is_public | BOOLEAN | DEFAULT FALSE | — |
| created_at | TIMESTAMP | — | — |
| updated_at | TIMESTAMP | — | — |

---

### 17. flashcards

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK | — |
| deck_id | BIGINT UNSIGNED | FK, NOT NULL | Parent deck |
| front | TEXT | NOT NULL | Question / front side |
| back | TEXT | NOT NULL | Answer / back side |
| hint | TEXT | NULL | Optional hint |
| tags | JSON | NULL | e.g., `["algorithms"]` |
| ease_factor | DECIMAL(4,2) | DEFAULT 2.50 | SM-2 ease factor |
| interval_days | INTEGER | DEFAULT 0 | Days until next review |
| repetitions | INTEGER | DEFAULT 0 | Successful review count |
| status | ENUM | DEFAULT 'new' | new/learning/review/relearning/suspended |
| next_review_at | TIMESTAMP | NULL | Scheduled review date |
| last_reviewed_at | TIMESTAMP | NULL | — |
| created_at | TIMESTAMP | — | — |
| updated_at | TIMESTAMP | — | — |

**Key Indexes**:
```sql
INDEX (deck_id, next_review_at)
INDEX (deck_id, status)
```

---

### 18. flashcard_reviews

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK | — |
| flashcard_id | BIGINT UNSIGNED | FK, NOT NULL | — |
| user_id | BIGINT UNSIGNED | FK, NOT NULL | — |
| rating | TINYINT | NOT NULL | 1=Again 2=Hard 3=Good 4=Easy |
| prev_ease | DECIMAL(4,2) | NOT NULL | Before |
| new_ease | DECIMAL(4,2) | NOT NULL | After |
| prev_interval | INTEGER | NOT NULL | Before (days) |
| new_interval | INTEGER | NOT NULL | After (days) |
| response_time_ms | INTEGER | NULL | How fast they answered |
| created_at | TIMESTAMP | NOT NULL | — |

---

### 19. xp_transactions

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK | — |
| user_id | BIGINT UNSIGNED | FK, NOT NULL | — |
| amount | SMALLINT | NOT NULL | XP earned (can be negative) |
| action | VARCHAR(50) | NOT NULL | complete_topic, daily_streak, etc. |
| reference_id | BIGINT UNSIGNED | NULL | ID of related entity |
| description | VARCHAR(255) | NULL | Human-readable |
| created_at | TIMESTAMP | NOT NULL | — |

**Key Indexes**:
```sql
INDEX (user_id, created_at)
INDEX (user_id, action)
```

---

### 20. badges

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK | — |
| slug | VARCHAR(100) | UNIQUE, NOT NULL | Machine-readable key |
| name | VARCHAR(100) | NOT NULL | Display name |
| description | TEXT | NOT NULL | How to earn it |
| icon | VARCHAR(255) | NOT NULL | Emoji or icon path |
| category | VARCHAR(50) | NULL | learning/social/streak/etc. |
| xp_reward | SMALLINT | DEFAULT 0 | XP on earning |
| sort_order | INTEGER | DEFAULT 0 | — |

---

### 22. streaks

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK | — |
| user_id | BIGINT UNSIGNED | FK, UNIQUE | One streak per user |
| current_streak | INTEGER | DEFAULT 0 | Days |
| longest_streak | INTEGER | DEFAULT 0 | All-time best |
| last_activity_date | DATE | NULL | Last activity date |
| freeze_count | INTEGER | DEFAULT 0 | Streak freeze tokens |
| updated_at | TIMESTAMP | — | — |

---

### 32. journal_entries

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK | — |
| user_id | BIGINT UNSIGNED | FK, NOT NULL | — |
| entry_date | DATE | NOT NULL | Entry date |
| what_i_learned | TEXT | NULL | — |
| challenges | TEXT | NULL | — |
| wins | TEXT | NULL | — |
| tomorrow_goals | TEXT | NULL | — |
| mood_score | TINYINT | NULL | 1–5 |
| tags | JSON | NULL | — |
| is_public | BOOLEAN | DEFAULT FALSE | Shares on public profile |
| created_at | TIMESTAMP | — | — |
| updated_at | TIMESTAMP | — | — |

**Unique Constraint**: `(user_id, entry_date)` — one entry per day

---

### 34. habits

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK | — |
| user_id | BIGINT UNSIGNED | FK, NOT NULL | — |
| name | VARCHAR(100) | NOT NULL | Habit name |
| description | TEXT | NULL | — |
| icon | VARCHAR(50) | NULL | Emoji |
| color | VARCHAR(20) | NULL | Color hex |
| target_frequency | ENUM | DEFAULT 'daily' | daily/weekly |
| target_count | TINYINT | DEFAULT 1 | Times per period |
| current_streak | INTEGER | DEFAULT 0 | — |
| is_active | BOOLEAN | DEFAULT TRUE | — |
| created_at | TIMESTAMP | — | — |
| updated_at | TIMESTAMP | — | — |

### 35. habit_logs

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK | — |
| habit_id | BIGINT UNSIGNED | FK, NOT NULL | — |
| user_id | BIGINT UNSIGNED | FK, NOT NULL | — |
| logged_date | DATE | NOT NULL | — |
| created_at | TIMESTAMP | — | — |

---

### 36. pomodoro_sessions

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK | — |
| user_id | BIGINT UNSIGNED | FK, NOT NULL | — |
| topic_id | BIGINT UNSIGNED | FK, NULL | Optional focus topic |
| duration_minutes | SMALLINT | NOT NULL | Session length |
| break_minutes | SMALLINT | NOT NULL | Break length |
| status | ENUM | DEFAULT 'started' | started/completed/abandoned |
| started_at | TIMESTAMP | NOT NULL | — |
| completed_at | TIMESTAMP | NULL | — |

---

### 40. webhooks

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK | — |
| user_id | BIGINT UNSIGNED | FK, NOT NULL | Owner |
| url | VARCHAR(2048) | NOT NULL | Endpoint URL |
| secret | VARCHAR(64) | NOT NULL | HMAC signing secret |
| events | JSON | NOT NULL | `["roadmap.completed"]` |
| is_active | BOOLEAN | DEFAULT TRUE | — |
| last_triggered_at | TIMESTAMP | NULL | — |
| failure_count | TINYINT | DEFAULT 0 | Consecutive failures |
| created_at | TIMESTAMP | — | — |
| updated_at | TIMESTAMP | — | — |

**Supported Webhook Events**:
- `roadmap.completed` — Roadmap reaches 100%
- `topic.completed` — Topic marked complete
- `certificate.issued` — Certificate generated
- `badge.earned` — Badge awarded
- `streak.updated` — Streak incremented

---

## Entity Relationship Overview

```
users
 ├── roadmaps ──────────────────────────────────────┐
 │    ├── roadmap_phases                             │
 │    ├── topics                                     │
 │    │    ├── resources                             │
 │    │    ├── topic_time_logs                       │
 │    │    ├── topic_reflections                     │
 │    │    └── topic_dependencies (self-join)        │
 │    ├── certificates                               │
 │    ├── roadmap_collaborators (M:M users)          │
 │    ├── roadmap_ratings (M:M users)                │
 │    └── roadmap_bookmarks (M:M users)              │
 │                                                   │
 ├── flashcard_decks                                 │
 │    └── flashcards                                 │
 │         └── flashcard_reviews                     │
 │                                                   │
 ├── xp_transactions                                 │
 ├── badges (M:M via user_badges)                    │
 ├── streak (1:1)                                    │
 ├── journal_entries                                 │
 ├── habits ── habit_logs                            │
 ├── pomodoro_sessions                               │
 ├── activity_logs                                   │
 ├── user_login_history                              │
 ├── notifications                                   │
 ├── webhooks                                        │
 ├── follows (self-join M:M)                         │
 └── user_skills                                     │
                                                     │
roadmaps (public explorer) ─────────────────────────┘
```

---

## Migration Order

Run in this order to satisfy foreign key dependencies:

```
-- Core
1.  users
2.  password_reset_tokens
3.  sessions
4.  personal_access_tokens

-- Roadmaps
5.  roadmaps
6.  roadmap_phases
7.  topics
8.  topic_dependencies

-- Resources
9.  resources
10. resource_tags
11. topic_time_logs
12. topic_reflections

-- Certificates
13. certificates
14. certificate_portfolios

-- SRS
15. flashcard_decks
16. flashcards
17. flashcard_reviews

-- Gamification
18. xp_transactions
19. badges
20. user_badges
21. streaks
22. daily_challenges

-- Social
23. follows
24. roadmap_collaborators
25. roadmap_ratings
26. roadmap_reviews
27. roadmap_comments
28. roadmap_bookmarks
29. study_buddy_pairs
30. mentorship_requests

-- Journal & Mood
31. journal_entries
32. mood_logs

-- Productivity
33. habits
34. habit_logs
35. pomodoro_sessions

-- Analytics
36. activity_logs
37. user_login_history
38. weekly_reports

-- Integrations
39. webhooks
40. webhook_deliveries
41. integrations
42. push_subscriptions

-- Content
43. notifications
44. learning_paths
45. learning_path_items
46. changelog_entries
47. user_skills
48. feature_flags
49. reports

-- OAuth
50. user_providers
```

---

## Key Indexes & Performance

### Compound Indexes (High-Priority)

```sql
-- Dashboard: load user's active roadmaps
INDEX ix_roadmaps_user_status_updated (user_id, status, updated_at DESC)

-- Public explore: sorted by score
INDEX ix_roadmaps_public_score (is_public, status, composite_score DESC)

-- SRS due cards
INDEX ix_flashcards_due (deck_id, next_review_at, status)

-- XP aggregation
INDEX ix_xp_user_date (user_id, created_at DESC)

-- Activity heatmap (52 weeks)
INDEX ix_activity_user_date (user_id, DATE(created_at))

-- Notification inbox
INDEX ix_notifications_user_unread (user_id, read_at, created_at DESC)

-- Streak lookup
UNIQUE ix_streaks_user (user_id)

-- Journal (one per day)
UNIQUE ix_journal_user_date (user_id, entry_date)
```

---

## Caching Strategy

```php
// User dashboard stats (refreshed on each significant event)
Cache::remember("user.{$id}.dashboard_stats", 600, fn() => ...);

// Leaderboard (recomputed hourly by scheduler)
Cache::remember("leaderboard.week", 3600, fn() => ...);

// Public roadmap cards (15 min)
Cache::remember("explore.roadmaps.page.{$page}", 900, fn() => ...);

// SRS due count (invalidated after each review)
Cache::remember("user.{$id}.srs_due_count", 300, fn() =>
    Flashcard::dueForUser($id)->count()
);
```

---

## Backup & Maintenance (Windows)

### Daily Backup Script (PowerShell)

```powershell
# save as: backup-db.ps1 — run via Task Scheduler
$date     = Get-Date -Format "yyyyMMdd_HHmmss"
$backupDir = "C:\backups\learnforge"
$dbName    = "learnforge"

New-Item -ItemType Directory -Force -Path $backupDir | Out-Null

# mysqldump via Laragon's bundled mysql
& "C:\laragon\bin\mysql\mysql-8.0\bin\mysqldump.exe" `
    -uroot $dbName | gzip | Out-File "$backupDir\backup_$date.sql.gz"

# Keep 30 days
Get-ChildItem "$backupDir\*.sql.gz" |
    Where-Object { $_.CreationTime -lt (Get-Date).AddDays(-30) } |
    Remove-Item
```

### Artisan Maintenance Commands

```powershell
# Clear all caches
php artisan optimize:clear

# Rebuild TNTSearch full-text index
php artisan scout:import "App\Models\Roadmap"
php artisan scout:import "App\Models\Topic"
php artisan scout:import "App\Models\Resource"

# Recompute leaderboard
php artisan leaderboards:compute

# Generate sitemap
php artisan sitemap:generate

# Send weekly digest manually
php artisan digests:send

# Check failed jobs
php artisan queue:failed
php artisan queue:retry all
```

---

*LearnForge Database Schema v4.0 — 66 tables, MySQL 8.0+, Laravel 12.x, Windows + Laragon*
