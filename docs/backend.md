# Backend Architecture Documentation
## LearnForge — Laravel 12.x Service Pattern

**Version:** 4.0 (Windows + VSCode Edition)
**Last Updated:** March 2026
**Framework:** Laravel 12.x
**PHP Version:** 8.3+
**Dev Environment:** Laragon Full (Windows) — PHP 8.3, MySQL 8, Redis, Nginx, Node.js

---

## Table of Contents

1. [Architecture Overview](#architecture-overview)
2. [Directory Structure](#directory-structure)
3. [Models & Eloquent Relationships](#models--eloquent-relationships)
4. [Services Layer](#services-layer)
5. [Controllers](#controllers)
6. [Form Requests & Validation](#form-requests--validation)
7. [Jobs & Queues](#jobs--queues)
8. [Events & Listeners](#events--listeners)
9. [Broadcasting (Pusher)](#broadcasting-pusher)
10. [Middleware](#middleware)
11. [API Resources](#api-resources)
12. [Package Reference](#package-reference)
13. [Testing Strategy](#testing-strategy)

---

## Architecture Overview

### Service-Oriented Architecture

```
HTTP Request
    │
    ▼
Routes (web.php / api.php)
    │
    ▼
Middleware (Auth, CSRF, Throttle, Honeypot)
    │
    ▼
Controllers (thin — orchestration only)
    │
    ▼
Form Requests (Validation & Authorization)
    │
    ▼
Services (Business Logic)
    │
    ├── Models (Eloquent ORM)
    ├── Jobs/Queues (async work)
    └── Events/Listeners (side effects)
            │
            ▼
        Database (MySQL 8 + Redis)
```

### Key Principles

1. **Thin Controllers**: Controllers only orchestrate — no business logic
2. **Service Classes**: All domain logic lives in dedicated service classes
3. **Dependency Injection**: Services injected via constructor
4. **Eloquent ORM**: All DB interaction through models
5. **Form Requests**: Validation decoupled from controllers
6. **Queue for Heavy Work**: AI calls, PDF generation, emails → background jobs
7. **Event-Driven Side Effects**: XP awards, badge checks, streak updates via events

---

## Directory Structure

```
app/
├── Console/
│   └── Commands/
│       ├── GenerateSitemap.php
│       ├── ProcessSrsSchedule.php
│       ├── SendWeeklyDigests.php
│       └── ComputeLeaderboards.php
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   │   ├── LoginController.php
│   │   │   ├── RegisterController.php
│   │   │   ├── ForgotPasswordController.php
│   │   │   ├── ResetPasswordController.php
│   │   │   ├── TwoFactorController.php
│   │   │   └── SocialiteController.php    # Google/GitHub/LinkedIn OAuth
│   │   ├── DashboardController.php
│   │   ├── RoadmapController.php
│   │   ├── TopicController.php
│   │   ├── ResourceController.php
│   │   ├── CertificateController.php
│   │   ├── FlashcardController.php
│   │   ├── ReviewController.php            # SRS review sessions
│   │   ├── AnalyticsController.php
│   │   ├── JournalController.php
│   │   ├── HabitController.php
│   │   ├── PomodoroController.php
│   │   ├── NotificationController.php
│   │   ├── SearchController.php
│   │   ├── LeaderboardController.php
│   │   ├── SocialController.php            # Follow, feed, explore
│   │   ├── ProfileController.php
│   │   ├── AchievementController.php
│   │   ├── WebhookController.php
│   │   ├── IntegrationController.php
│   │   ├── AIController.php
│   │   ├── ChangelogController.php
│   │   ├── LearningPathController.php
│   │   └── Admin/
│   │       ├── AdminDashboardController.php
│   │       ├── UserManagementController.php
│   │       └── ModerationController.php
│   ├── Middleware/
│   │   ├── Authenticate.php
│   │   ├── CheckRoadmapOwnership.php
│   │   ├── HoneypotMiddleware.php
│   │   ├── EnsureEmailVerified.php
│   │   └── AdminOnly.php
│   ├── Requests/
│   │   ├── Auth/
│   │   │   ├── LoginRequest.php
│   │   │   └── RegisterRequest.php
│   │   ├── Roadmap/
│   │   │   ├── StoreRoadmapRequest.php
│   │   │   ├── UpdateRoadmapRequest.php
│   │   │   └── ReorderTopicsRequest.php
│   │   ├── Topic/
│   │   │   ├── StoreTopicRequest.php
│   │   │   ├── UpdateTopicRequest.php
│   │   │   └── UpdateTopicStatusRequest.php
│   │   ├── Resource/
│   │   │   ├── StoreResourceRequest.php
│   │   │   └── UpdateResourceRequest.php
│   │   └── AI/
│   │       └── GenerateRoadmapRequest.php
│   └── Resources/
│       ├── RoadmapResource.php
│       ├── TopicResource.php
│       ├── ResourceResource.php
│       ├── CertificateResource.php
│       ├── FlashcardResource.php
│       └── UserResource.php
├── Models/
│   ├── User.php
│   ├── Roadmap.php
│   ├── RoadmapPhase.php
│   ├── Topic.php
│   ├── TopicDependency.php
│   ├── Resource.php
│   ├── ResourceTag.php
│   ├── FlashcardDeck.php
│   ├── Flashcard.php
│   ├── FlashcardReview.php
│   ├── Certificate.php
│   ├── ActivityLog.php
│   ├── XpTransaction.php
│   ├── Badge.php
│   ├── UserBadge.php
│   ├── Streak.php
│   ├── Follow.php
│   ├── RoadmapRating.php
│   ├── RoadmapReview.php
│   ├── RoadmapBookmark.php
│   ├── RoadmapCollaborator.php
│   ├── RoadmapComment.php
│   ├── JournalEntry.php
│   ├── TopicReflection.php
│   ├── MoodLog.php
│   ├── Habit.php
│   ├── HabitLog.php
│   ├── Notification.php
│   ├── PomodoroSession.php
│   ├── TopicTimeLog.php
│   ├── Webhook.php
│   ├── WebhookDelivery.php
│   ├── Integration.php
│   ├── UserSkill.php
│   ├── StudyBuddyPair.php
│   ├── LearningPath.php
│   ├── LearningPathItem.php
│   ├── ChangelogEntry.php
│   └── UserLoginHistory.php
├── Services/
│   ├── Auth/
│   │   ├── AuthService.php
│   │   ├── TwoFactorService.php        # TOTP via pragmarx/google2fa
│   │   └── PasswordResetService.php
│   ├── Roadmap/
│   │   ├── RoadmapService.php
│   │   ├── RoadmapProgressService.php
│   │   ├── RoadmapHealthService.php    # Health score (0-100)
│   │   └── RoadmapCloneService.php
│   ├── Topic/
│   │   ├── TopicService.php
│   │   └── TopicProgressService.php
│   ├── Resource/
│   │   ├── ResourceService.php
│   │   └── FileUploadService.php
│   ├── Certificate/
│   │   ├── CertificateService.php
│   │   ├── CertificatePdfService.php   # barryvdh/laravel-dompdf
│   │   └── CertificateVerifyService.php
│   ├── SRS/
│   │   ├── SmTwoAlgorithmService.php   # SM-2 algorithm
│   │   ├── FlashcardService.php
│   │   └── ReviewSessionService.php
│   ├── AI/
│   │   ├── GeminiService.php           # Google Gemini 1.5 Flash HTTP client
│   │   ├── RoadmapGeneratorService.php
│   │   ├── FlashcardGeneratorService.php
│   │   └── AISchedulingService.php
│   ├── Gamification/
│   │   ├── XpService.php
│   │   ├── BadgeService.php
│   │   ├── StreakService.php
│   │   └── LeaderboardService.php
│   ├── Analytics/
│   │   ├── AnalyticsService.php
│   │   └── HeatmapService.php
│   ├── Notification/
│   │   └── NotificationService.php
│   ├── Social/
│   │   ├── FollowService.php
│   │   └── FeedService.php
│   ├── Search/
│   │   └── SearchService.php           # TNTSearch via Laravel Scout
│   ├── Sharing/
│   │   ├── QrCodeService.php           # simplesoftwareio/simple-qrcode
│   │   ├── OgImageService.php          # PHP/GD or Browsershot
│   │   └── BadgeService.php            # SVG progress badges
│   ├── Export/
│   │   ├── RoadmapExportService.php    # JSON/MD/CSV/PDF/iCal/Anki
│   │   └── AccountExportService.php    # GDPR full data export
│   └── File/
│       └── FileUploadService.php
├── Jobs/
│   ├── GenerateCertificatePdf.php
│   ├── SendCertificateEmail.php
│   ├── GenerateAIRoadmap.php
│   ├── GenerateAIFlashcards.php
│   ├── SendWeeklyDigest.php
│   ├── ProcessSrsSchedule.php
│   ├── ComputeLeaderboard.php
│   ├── GenerateOGImage.php
│   ├── DeliverWebhook.php
│   ├── SyncGitHubGist.php
│   └── SendPushNotification.php
├── Events/
│   ├── RoadmapCompleted.php
│   ├── TopicCompleted.php
│   ├── TopicStatusChanged.php
│   ├── CertificateGenerated.php
│   ├── BadgeEarned.php
│   ├── LevelUp.php
│   ├── StreakUpdated.php
│   └── SrsReviewCompleted.php
├── Listeners/
│   ├── AwardXpForTopicCompletion.php
│   ├── CheckAndAwardBadges.php
│   ├── UpdateRoadmapProgress.php
│   ├── UpdateStreak.php
│   ├── BroadcastNotification.php
│   ├── TriggerWebhooks.php
│   └── LogUserActivity.php
└── Providers/
    ├── AppServiceProvider.php
    ├── AuthServiceProvider.php
    └── EventServiceProvider.php
```

---

## Models & Eloquent Relationships

### User Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    protected $fillable = [
        'username', 'email', 'password', 'full_name', 'headline', 'profession',
        'bio', 'location', 'website', 'github_username', 'linkedin_url', 'twitter_username',
        'profile_picture', 'cover_image', 'timezone', 'locale', 'theme', 'accent_color',
        'available_hours_week', 'is_mentor', 'is_public',
        'two_factor_secret', 'two_factor_confirmed',
        'onboarding_completed', 'last_active_at',
    ];

    protected $hidden = ['password', 'remember_token', 'two_factor_secret'];

    protected $casts = [
        'email_verified_at'    => 'datetime',
        'password'             => 'hashed',
        'is_mentor'            => 'boolean',
        'is_public'            => 'boolean',
        'two_factor_confirmed' => 'boolean',
        'onboarding_completed' => 'boolean',
        'available_hours_week' => 'decimal:1',
        'last_active_at'       => 'datetime',
        'deleted_at'           => 'datetime',
    ];

    // ── Relationships ──
    public function roadmaps()        { return $this->hasMany(Roadmap::class); }
    public function certificates()    { return $this->hasMany(Certificate::class); }
    public function flashcardDecks()  { return $this->hasMany(FlashcardDeck::class); }
    public function streak()          { return $this->hasOne(Streak::class); }
    public function xpTransactions()  { return $this->hasMany(XpTransaction::class); }
    public function badges()          { return $this->belongsToMany(Badge::class, 'user_badges')->withTimestamps(); }
    public function journalEntries()  { return $this->hasMany(JournalEntry::class); }
    public function habits()          { return $this->hasMany(Habit::class); }
    public function pomodoroSessions(){ return $this->hasMany(PomodoroSession::class); }
    public function skills()          { return $this->hasMany(UserSkill::class); }
    public function activityLogs()    { return $this->hasMany(ActivityLog::class); }
    public function following()       { return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id'); }
    public function followers()       { return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id'); }
    public function notifications()   { return $this->hasMany(Notification::class); }
    public function webhooks()        { return $this->hasMany(Webhook::class); }

    // ── Helpers ──
    public function getTotalXpAttribute(): int
    {
        return $this->xpTransactions()->sum('amount');
    }

    public function getProfileUrlAttribute(): string
    {
        return route('profile.show', $this->username);
    }

    // ── Scopes ──
    public function scopePublic($query)  { return $query->where('is_public', true); }
    public function scopeMentors($query) { return $query->where('is_mentor', true); }
}
```

### Roadmap Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Roadmap extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'slug', 'description', 'category', 'cover_image',
        'difficulty_level', 'tags', 'target_completion_date', 'is_public', 'visibility',
        'total_score', 'progress_percentage', 'weighted_progress', 'quality_score',
        'composite_score', 'status', 'cloned_from_id',
        'total_clones', 'total_views', 'total_bookmarks', 'average_rating', 'ratings_count',
    ];

    protected $casts = [
        'tags'                   => 'array',
        'target_completion_date' => 'date',
        'is_public'              => 'boolean',
        'total_score'            => 'decimal:2',
        'progress_percentage'    => 'decimal:2',
        'weighted_progress'      => 'decimal:2',
        'quality_score'          => 'decimal:2',
        'composite_score'        => 'decimal:2',
        'average_rating'         => 'decimal:2',
        'deleted_at'             => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($roadmap) {
            if (empty($roadmap->slug)) {
                $roadmap->slug = Str::slug($roadmap->title) . '-' . Str::random(6);
            }
        });
    }

    // ── Relationships ──
    public function user()          { return $this->belongsTo(User::class); }
    public function phases()        { return $this->hasMany(RoadmapPhase::class)->orderBy('order_index'); }
    public function topics()        { return $this->hasMany(Topic::class)->orderBy('order_index'); }
    public function certificates()  { return $this->hasMany(Certificate::class); }
    public function collaborators() { return $this->belongsToMany(User::class, 'roadmap_collaborators')->withPivot('role'); }
    public function ratings()       { return $this->hasMany(RoadmapRating::class); }
    public function reviews()       { return $this->hasMany(RoadmapReview::class); }
    public function comments()      { return $this->hasMany(RoadmapComment::class); }
    public function clonedFrom()    { return $this->belongsTo(Roadmap::class, 'cloned_from_id'); }

    // ── Scopes ──
    public function scopeActive($query)    { return $query->where('status', 'active'); }
    public function scopeCompleted($query) { return $query->where('status', 'completed'); }
    public function scopePublic($query)    { return $query->where('is_public', true)->where('status', 'active'); }

    // ── Accessors ──
    public function getTotalTopicsAttribute(): int
    {
        return $this->topics()->count();
    }

    public function getCompletedTopicsAttribute(): int
    {
        return $this->topics()->where('status', 'completed')->count();
    }
}
```

### Topic Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'roadmap_id', 'phase_id', 'parent_topic_id', 'title', 'description',
        'estimated_hours', 'actual_hours', 'difficulty_level', 'priority',
        'order_index', 'weight', 'status', 'quality_rating', 'confidence_level',
        'started_at', 'completed_at', 'scheduled_date', 'due_date',
    ];

    protected $casts = [
        'estimated_hours'  => 'decimal:2',
        'actual_hours'     => 'decimal:2',
        'priority'         => 'integer',
        'order_index'      => 'integer',
        'weight'           => 'integer',
        'quality_rating'   => 'integer',
        'confidence_level' => 'integer',
        'started_at'       => 'datetime',
        'completed_at'     => 'datetime',
        'scheduled_date'   => 'date',
        'due_date'         => 'date',
    ];

    public function roadmap()      { return $this->belongsTo(Roadmap::class); }
    public function phase()        { return $this->belongsTo(RoadmapPhase::class); }
    public function parentTopic()  { return $this->belongsTo(Topic::class, 'parent_topic_id'); }
    public function subTopics()    { return $this->hasMany(Topic::class, 'parent_topic_id')->orderBy('order_index'); }
    public function resources()    { return $this->hasMany(Resource::class)->orderBy('order_index'); }
    public function timeLogs()     { return $this->hasMany(TopicTimeLog::class); }
    public function flashcardDecks() { return $this->hasMany(FlashcardDeck::class); }
    public function prerequisites(){ return $this->belongsToMany(Topic::class, 'topic_dependencies', 'topic_id', 'depends_on_id'); }
    public function reflections()  { return $this->hasMany(TopicReflection::class); }

    public function scopeRootTopics($query)  { return $query->whereNull('parent_topic_id'); }
    public function scopeCompleted($query)   { return $query->where('status', 'completed'); }
    public function scopeInProgress($query)  { return $query->where('status', 'in_progress'); }
    public function scopeOverdue($query)     { return $query->whereNotNull('due_date')->where('due_date', '<', now())->whereNotIn('status', ['completed', 'skipped']); }
}
```

---

## Services Layer

### SRS SM-2 Algorithm Service

```php
<?php

namespace App\Services\SRS;

use App\Models\Flashcard;
use Carbon\Carbon;

class SmTwoAlgorithmService
{
    /**
     * Process a card review using the SM-2 algorithm.
     * Ratings: 1=Again, 2=Hard, 3=Good, 4=Easy
     */
    public function processReview(Flashcard $card, int $rating): array
    {
        $ease        = $card->ease_factor;
        $interval    = $card->interval_days;
        $repetitions = $card->repetitions;

        match ($rating) {
            1 => [ // Again — reset
                $ease        = max(1.3, $ease - 0.20),
                $interval    = 1,
                $repetitions = 0,
            ],
            2 => [ // Hard
                $ease        = max(1.3, $ease - 0.15),
                $interval    = max(1, (int) ($interval * 1.2)),
            ],
            3 => [ // Good
                $interval    = $repetitions === 0 ? 1 : ($repetitions === 1 ? 6 : (int) round($interval * $ease)),
                $repetitions = $repetitions + 1,
            ],
            4 => [ // Easy
                $ease        = $ease + 0.15,
                $interval    = $repetitions === 0 ? 4 : (int) round($interval * $ease * 1.3),
                $repetitions = $repetitions + 1,
            ],
        };

        $nextReviewAt = Carbon::now()->addDays($interval);

        $card->update([
            'ease_factor'    => round($ease, 2),
            'interval_days'  => $interval,
            'repetitions'    => $repetitions,
            'next_review_at' => $nextReviewAt,
            'status'         => $rating === 1 ? 'relearning' : ($interval >= 21 ? 'review' : 'learning'),
        ]);

        return [
            'new_interval'    => $interval,
            'next_review_at'  => $nextReviewAt->toDateString(),
            'ease_factor'     => $ease,
        ];
    }

    public function getDueCards(int $userId, int $deckId = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = Flashcard::query()
            ->whereHas('deck', fn($q) => $q->where('user_id', $userId))
            ->where('next_review_at', '<=', now())
            ->whereNotIn('status', ['suspended']);

        if ($deckId) {
            $query->where('deck_id', $deckId);
        }

        return $query->inRandomOrder()->get();
    }
}
```

### AI (Gemini) Service

```php
<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    private string $apiKey;
    private string $model = 'gemini-1.5-flash';
    private string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
    }

    public function generateRoadmap(string $prompt): array
    {
        $systemPrompt = "You are an expert learning roadmap creator. Generate a structured learning roadmap as JSON with: title, description, category, difficulty, estimated_weeks, topics (array of {title, description, estimated_hours, difficulty, resources[]}).";

        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->timeout(30)
            ->post("{$this->baseUrl}/models/{$this->model}:generateContent?key={$this->apiKey}", [
                'contents' => [
                    ['role' => 'user', 'parts' => [['text' => $systemPrompt . "\n\n" . $prompt]]]
                ],
                'generationConfig' => [
                    'responseMimeType' => 'application/json',
                    'temperature'      => 0.7,
                    'maxOutputTokens'  => 8192,
                ],
            ]);

        if ($response->failed()) {
            Log::error('Gemini API error', ['status' => $response->status(), 'body' => $response->body()]);
            throw new \RuntimeException('AI service unavailable. Please try again.');
        }

        $text = $response->json('candidates.0.content.parts.0.text');
        return json_decode($text, true) ?? [];
    }

    public function generateFlashcards(string $topicContent, int $count = 10): array
    {
        $prompt = "Generate {$count} flashcards from this content. Return JSON array of {front, back}.\n\n{$topicContent}";
        return $this->generateRoadmap($prompt); // reuses the same HTTP call pattern
    }
}
```

### XP Service (Gamification)

```php
<?php

namespace App\Services\Gamification;

use App\Models\User;
use App\Models\XpTransaction;
use App\Events\LevelUp;

class XpService
{
    const XP_TABLE = [
        'create_roadmap'      => 100,
        'add_topic'           => 10,
        'complete_topic'      => 50,
        'complete_roadmap'    => 500,
        'log_study_hour'      => 25,
        'daily_streak'        => 15,
        'rate_topic'          => 10,
        'srs_review_session'  => 20,
        'srs_all_cards_today' => 50,
        'add_resource'        => 5,
        'add_note'            => 5,
        'share_roadmap'       => 25,
        'roadmap_cloned'      => 50,
        'streak_7day'         => 200,
        'streak_30day'        => 1000,
        'journal_entry'       => 10,
    ];

    public function award(User $user, string $action, ?int $referenceId = null): int
    {
        $amount = self::XP_TABLE[$action] ?? 0;
        if ($amount === 0) return 0;

        $prevXp = $user->total_xp;

        XpTransaction::create([
            'user_id'      => $user->id,
            'amount'       => $amount,
            'action'       => $action,
            'reference_id' => $referenceId,
            'description'  => ucreplace('_', ' ', $action),
        ]);

        // Check for level-up
        $newXp = $prevXp + $amount;
        if ($this->getLevel($newXp) > $this->getLevel($prevXp)) {
            event(new LevelUp($user, $this->getLevel($newXp)));
        }

        return $amount;
    }

    public function getLevel(int $xp): int
    {
        return match(true) {
            $xp >= 200001 => (int) (76 + ($xp - 200001) / 10000),
            $xp >= 75001  => (int) (51 + ($xp - 75001) / 5000),
            $xp >= 20001  => (int) (26 + ($xp - 20001) / 2222),
            $xp >= 5001   => (int) (11 + ($xp - 5001) / 1000),
            default       => max(1, (int) ($xp / 500) + 1),
        };
    }
}
```

### Roadmap Progress Service

```php
<?php

namespace App\Services\Roadmap;

use App\Models\Roadmap;

class RoadmapProgressService
{
    public function recalculate(Roadmap $roadmap): void
    {
        $topics = $roadmap->topics()->get();
        $total  = $topics->count();

        if ($total === 0) {
            $roadmap->update(['progress_percentage' => 0, 'composite_score' => 0]);
            return;
        }

        $completed    = $topics->where('status', 'completed')->count();
        $completionPc = round(($completed / $total) * 100, 2);

        // Weighted progress
        $totalWeight     = $topics->sum('weight');
        $completedWeight = $topics->where('status', 'completed')->sum('weight');
        $weightedPc = $totalWeight > 0
            ? round(($completedWeight / $totalWeight) * 100, 2)
            : $completionPc;

        // Time efficiency
        $estimatedHrs = $topics->sum('estimated_hours');
        $actualHrs    = $topics->sum('actual_hours');
        $timePc = $estimatedHrs > 0 && $actualHrs > 0
            ? round(min(100, ($estimatedHrs / $actualHrs) * 100), 2)
            : 50;

        // Quality score (completed topics with ratings)
        $ratedTopics = $topics->where('status', 'completed')->whereNotNull('quality_rating');
        $qualityPc   = $ratedTopics->count() > 0
            ? round(($ratedTopics->avg('quality_rating') / 5) * 100, 2)
            : 50;

        // Composite (weighted average)
        $composite = round(
            ($completionPc * 0.40) + ($weightedPc * 0.30) + ($timePc * 0.15) + ($qualityPc * 0.15),
            2
        );

        $roadmap->update([
            'progress_percentage' => $completionPc,
            'weighted_progress'   => $weightedPc,
            'quality_score'       => $qualityPc,
            'composite_score'     => $composite,
            'status'              => $completionPc >= 100 ? 'completed' : 'active',
        ]);
    }
}
```

---

## Controllers

### RoadmapController (thin)

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\Roadmap\StoreRoadmapRequest;
use App\Http\Requests\Roadmap\UpdateRoadmapRequest;
use App\Services\Roadmap\RoadmapService;
use App\Models\Roadmap;
use Illuminate\Http\Request;

class RoadmapController extends Controller
{
    public function __construct(private RoadmapService $roadmapService) {}

    public function index()
    {
        $roadmaps = auth()->user()->roadmaps()
            ->with(['topics', 'certificates'])
            ->latest('updated_at')
            ->paginate(12);

        return view('roadmaps.index', compact('roadmaps'));
    }

    public function store(StoreRoadmapRequest $request)
    {
        $roadmap = $this->roadmapService->createRoadmap(auth()->user(), $request->validated());
        return redirect()->route('roadmaps.show', $roadmap)
            ->with('success', 'Roadmap created! Add your first topic to get started.');
    }

    public function show(Roadmap $roadmap)
    {
        $this->authorize('view', $roadmap);
        $roadmap->load(['phases', 'topics.resources', 'certificates']);
        return view('roadmaps.show', compact('roadmap'));
    }

    public function update(UpdateRoadmapRequest $request, Roadmap $roadmap)
    {
        $this->authorize('update', $roadmap);
        $roadmap = $this->roadmapService->updateRoadmap($roadmap, $request->validated());
        return back()->with('success', 'Roadmap updated.');
    }

    public function destroy(Roadmap $roadmap)
    {
        $this->authorize('delete', $roadmap);
        $this->roadmapService->deleteRoadmap($roadmap);
        return redirect()->route('dashboard')->with('success', 'Roadmap deleted.');
    }

    public function clone(Roadmap $roadmap)
    {
        $clone = $this->roadmapService->cloneRoadmap($roadmap, auth()->user());
        return redirect()->route('roadmaps.show', $clone)->with('success', 'Roadmap cloned to your workspace!');
    }
}
```

---

## Jobs & Queues

All jobs use the `redis` queue connection via Laravel Horizon.

```php
// GenerateAIRoadmap.php
class GenerateAIRoadmap implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 60;
    public int $tries   = 3;

    public function __construct(
        public User $user,
        public string $prompt,
        public string $sessionId    // For real-time progress via Pusher
    ) {}

    public function handle(GeminiService $ai, RoadmapService $roadmapSvc): void
    {
        $data    = $ai->generateRoadmap($this->prompt);
        $roadmap = $roadmapSvc->createRoadmapFromAI($this->user, $data);

        broadcast(new AIRoadmapGenerated($this->user, $roadmap, $this->sessionId));
    }
}
```

---

## Broadcasting (Pusher)

### Event Configuration

```php
// config/broadcasting.php (relevant section)
'pusher' => [
    'driver'  => 'pusher',
    'key'     => env('PUSHER_APP_KEY'),
    'secret'  => env('PUSHER_APP_SECRET'),
    'app_id'  => env('PUSHER_APP_ID'),
    'options' => [
        'cluster' => env('PUSHER_APP_CLUSTER', 'ap2'),
        'useTLS'  => true,
    ],
],
```

### Broadcastable Event Example

```php
// app/Events/BadgeEarned.php
class BadgeEarned implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public User $user, public Badge $badge) {}

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel("user.{$this->user->id}");
    }

    public function broadcastAs(): string { return 'badge.earned'; }

    public function broadcastWith(): array
    {
        return [
            'badge'   => ['name' => $this->badge->name, 'icon' => $this->badge->icon],
            'message' => "You earned the \"{$this->badge->name}\" badge!",
        ];
    }
}
```

---

## Package Reference

### Composer Packages (Laravel)

| Package | Purpose |
|---------|---------|
| `laravel/sanctum` | Session + API token auth |
| `laravel/breeze` | Auth scaffolding |
| `laravel/horizon` | Queue dashboard |
| `laravel/scout` | Full-text search integration |
| `laravel/telescope` | Dev debugger |
| `laravel/socialite` | OAuth (Google, GitHub, LinkedIn) |
| `pusher/pusher-php-server` | Pusher WebSocket broadcasting |
| `spatie/laravel-permission` | Role-based access control |
| `spatie/laravel-backup` | Automated backups |
| `spatie/laravel-media-library` | File management |
| `spatie/laravel-sluggable` | Auto-slug generation |
| `spatie/laravel-activitylog` | Activity logging |
| `spatie/laravel-sitemap` | Auto sitemap.xml |
| `spatie/laravel-feed` | RSS/Atom feed |
| `spatie/browsershot` | OG image via headless Chrome |
| `spatie/laravel-csp` | Content-Security-Policy headers |
| `barryvdh/laravel-dompdf` | PDF generation (certificates, exports) |
| `intervention/image` | Image resizing, avatar crop |
| `teamtnt/laravel-scout-tntsearch-driver` | Full-text search (pure PHP, no service) |
| `simplesoftwareio/simple-qrcode` | Server-side QR code generation |
| `pragmarx/google2fa-laravel` | TOTP 2FA (Google Authenticator compatible) |
| `tightenco/scribe` | API documentation auto-generation |
| `rap2hpoutre/laravel-log-viewer` | Web log viewer in admin panel |

### Install Command

```powershell
composer require \
    laravel/sanctum laravel/horizon laravel/scout laravel/socialite \
    pusher/pusher-php-server \
    spatie/laravel-permission spatie/laravel-backup spatie/laravel-media-library \
    spatie/laravel-sluggable spatie/laravel-activitylog spatie/laravel-sitemap \
    spatie/laravel-feed spatie/laravel-csp \
    barryvdh/laravel-dompdf intervention/image \
    teamtnt/laravel-scout-tntsearch-driver \
    simplesoftwareio/simple-qrcode \
    pragmarx/google2fa-laravel \
    tightenco/scribe
```

### TNTSearch Setup

```powershell
# .env
SCOUT_DRIVER=tntsearch

# Index models
php artisan scout:import "App\Models\Roadmap"
php artisan scout:import "App\Models\Topic"
php artisan scout:import "App\Models\Resource"
php artisan scout:import "App\Models\JournalEntry"
```

### 2FA TOTP Setup

```php
// app/Services/Auth/TwoFactorService.php
use PragmaRX\Google2FA\Google2FA;

class TwoFactorService
{
    private Google2FA $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    public function generateSecret(): string
    {
        return $this->google2fa->generateSecretKey();
    }

    public function getQrCodeUrl(User $user): string
    {
        return $this->google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $user->two_factor_secret
        );
    }

    public function verify(User $user, string $code): bool
    {
        return $this->google2fa->verifyKey($user->two_factor_secret, $code);
    }
}
```

---

## Testing Strategy

### Tools

| Tool | Purpose |
|------|---------|
| **Pest PHP** | Primary test framework |
| **Laravel Dusk** | Browser testing (ChromeDriver, Windows) |
| **Playwright** | Cross-browser E2E |
| **Lighthouse CI** | Performance regression testing |
| **Laravel Telescope** | Dev request/query debugger |

### Running Tests (Windows / Laragon)

```powershell
# All tests
php artisan test

# With coverage (Xdebug bundled in Laragon)
php artisan test --coverage

# Specific test
php artisan test --filter=RoadmapProgressTest

# Pest
.\vendor\bin\pest

# Browser tests
php artisan dusk
```

### Test Coverage Targets

| Layer | Target |
|-------|--------|
| Services | ≥ 80% |
| Controllers | All endpoints covered |
| Models | Key scopes + accessors |
| Browser (Dusk) | Critical flows: register, create roadmap, complete topic, SRS review |

---

*LearnForge Backend v4.0 — Laravel 12.x · PHP 8.3+ · Laragon Full (Windows) · No Docker*
