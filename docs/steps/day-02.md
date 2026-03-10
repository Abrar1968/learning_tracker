# Day 2: Backend Architecture & Services

## LearnForge — Service Pattern & Business Logic

**Day**: 2 of 3  
**Duration**: 10-12 hours  
**Framework**: Laravel 12.x  
**Goal**: Implement the Service-Oriented Architecture, Eloquent ORM logic, Repositories/Form Requests, and API Endpoints.

---

## 📋 Day 2 Overview

### Objectives

By end of Day 2, you will have:

- [ ] Eloquent Models with all relationships, casts, and scopes
- [ ] Service Layer (SRS SM-2 algorithm, Gamification, AI Gemini integration)
- [ ] Controllers (Thin orchestration)
- [ ] Form Requests (Validation rules per API specs)
- [ ] Jobs, Queues & Events (Background tasks)
- [ ] API Endpoints exposed

### Time Allocation

| Task                                | Duration  |
| ----------------------------------- | --------- |
| Eloquent Models & Relationships     | 3 hours   |
| Core Services (Roadmap, Topic)      | 2 hours   |
| Advanced Services (SRS, XP, Gemini) | 3 hours   |
| Controllers & Form Requests         | 2 hours   |
| Events, Jobs & Listeners            | 1-2 hours |

---

## 🏗️ Step 1: Eloquent Models (3 hours)

With 66 tables, our Models need exact relationships. All models should live in `app/Models`.

### 1.1 Core Models

Reference `backend.md` for full model attributes.

- **User.php**: Add relationships for `roadmaps`, `streak`, `xpTransactions`, `badges`, `flashcardDecks`, etc. Add helper `getTotalXpAttribute()`.
- **Roadmap.php**: Add `topics`, `phases`, `certificates`, `collaborators`, and composite score logic. Ensure `target_completion_date` casts to date.
- **Topic.php**: Add `parentTopic`, `subTopics`, `resources`, `flashcardDecks`, `timeLogs`. Includes self-referencing relationship for hierarchy.

### 1.2 Specialized Models

- **Flashcard.php**: Belongs to `FlashcardDeck`. Status enum `new, learning, review, relearning, suspended`.
- **Badge.php** & **UserBadge.php** (Pivot)
- **Streak.php**: `current_streak`, `longest_streak`.

---

## ⚙️ Step 2: Service Layer (5 hours)

Implement business logic in `app/Services/` so controllers remain thin.

### 2.1 Roadmap & Topic Services

`app/Services/Roadmap/RoadmapProgressService.php`:
Responsible for calculating the `composite_score` (40% completion + 30% weight + 15% time + 15% quality).

### 2.2 Gamification (XP Service)

`app/Services/Gamification/XpService.php`:

```php
public function award(User $user, string $action, ?int $referenceId = null): int {
    $amount = self::XP_TABLE[$action] ?? 0;
    // Log transaction, adjust total XP, check for LevelUp event
}
```

### 2.3 SRS (SM-2 Algorithm)

`app/Services/SRS/SmTwoAlgorithmService.php`:
Logic to process reviews (1=Again, 2=Hard, 3=Good, 4=Easy). Adjusts `ease_factor`, `interval_days`, and calculates `next_review_at`.

### 2.4 AI service (Gemini Flash)

`app/Services/AI/GeminiService.php`:
Uses Laravel HTTP client to call Google Gemini API (`gemini-1.5-flash`) for `generateRoadmap()` and `generateFlashcards()`.

---

## 🚦 Step 3: Controllers & Form Requests (2 hours)

### 3.1 HTTP Controllers

Create controllers in `app/Http/Controllers/`. They should ONLY accept requests, pass data to service classes, and return responses or views.

```bash
php artisan make:controller RoadmapController
php artisan make:controller TopicController
php artisan make:controller ResourceController
php artisan make:controller CertificateController
```

### 3.2 API Controllers

Expose the RESTful API under `/api/v1/` as documented in `api.md`. Include rate limiting (Sanctum/Session based).

### 3.3 Form Requests

```bash
php artisan make:request Roadmap/StoreRoadmapRequest
```

Enforce validation: `title` required, `difficulty_level` enum validation, `estimated_hours` numeric.

---

## 📡 Step 4: Events, Jobs & Broadcasting (2 hours)

### 4.1 Side effects via Events

When a topic is completed, we don't calculate everything inline.

- Dispatch `TopicCompleted` event.
- Listeners: `UpdateRoadmapProgress`, `AwardXpForTopicCompletion`, `UpdateStreak`.

### 4.2 Background Jobs (Queues)

Heavy tasks go to Redis.

```bash
php artisan make:job GenerateCertificatePdf
php artisan make:job GenerateAIRoadmap
```

---

## 🏁 Day 2 Wrap-up

- All business logic abstracted to Service classes.
- Database can be seeded with mock data covering all 66 tables.
- API endpoints return valid JSON matching `api.md` specs.
- Commit state: `git commit -m "Day 2: V4 Service architecture, SM-2, AI, Gamification"`
