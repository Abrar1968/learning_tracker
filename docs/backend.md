# Backend Architecture Documentation
## Learning Progress Tracker - Laravel Service Pattern Implementation

**Version:** 1.0  
**Last Updated:** December 11, 2025  
**Framework:** Laravel 12.x  
**PHP Version:** 8.3+

---

## Table of Contents

1. [Architecture Overview](#architecture-overview)
2. [Service Pattern Implementation](#service-pattern-implementation)
3. [Directory Structure](#directory-structure)
4. [Models & Eloquent Relationships](#models--eloquent-relationships)
5. [Services Layer](#services-layer)
6. [Controllers](#controllers)
7. [Form Requests & Validation](#form-requests--validation)
8. [Repositories (Optional)](#repositories-optional)
9. [Jobs & Queues](#jobs--queues)
10. [Events & Listeners](#events--listeners)
11. [Middleware](#middleware)
12. [API Resources](#api-resources)
13. [Database Migrations](#database-migrations)
14. [Seeders & Factories](#seeders--factories)
15. [Testing Strategy](#testing-strategy)
16. [Best Practices](#best-practices)

---

## Architecture Overview

### Service Pattern Architecture

The Learning Progress Tracker backend follows a **Service-Oriented Architecture** using Laravel's service pattern. This approach separates business logic from controllers, making the codebase more maintainable, testable, and scalable.

```
┌─────────────────────────────────────────────┐
│              HTTP Request                    │
└──────────────────┬──────────────────────────┘
                   │
┌──────────────────▼──────────────────────────┐
│              Routes (web.php)                │
└──────────────────┬──────────────────────────┘
                   │
┌──────────────────▼──────────────────────────┐
│              Middleware                      │
│  (Auth, CSRF, Throttle, etc.)               │
└──────────────────┬──────────────────────────┘
                   │
┌──────────────────▼──────────────────────────┐
│              Controllers                     │
│  (Thin controllers - orchestration only)    │
└──────────────────┬──────────────────────────┘
                   │
┌──────────────────▼──────────────────────────┐
│           Form Requests                      │
│  (Validation & Authorization)                │
└──────────────────┬──────────────────────────┘
                   │
┌──────────────────▼──────────────────────────┐
│              Services                        │
│  (Business Logic & Complex Operations)      │
└──────────────────┬──────────────────────────┘
                   │
┌──────────────────▼──────────────────────────┐
│         Models (Eloquent ORM)                │
│  (Data Access & Relationships)               │
└──────────────────┬──────────────────────────┘
                   │
┌──────────────────▼──────────────────────────┐
│              Database                        │
└─────────────────────────────────────────────┘
```

### Key Principles

1. **Single Responsibility**: Each class has one clear purpose
2. **Dependency Injection**: Services injected via constructor
3. **Service Container**: Laravel's IoC container manages dependencies
4. **Eloquent ORM**: All database interactions through Eloquent models
5. **Form Requests**: Validation separated from controllers
6. **API Resources**: Consistent data transformation for responses
7. **Type Hinting**: Strict typing for better IDE support and error prevention

---

## Directory Structure

```
app/
├── Console/
│   └── Commands/
├── Exceptions/
│   └── Handler.php
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   │   ├── LoginController.php
│   │   │   ├── RegisterController.php
│   │   │   ├── ForgotPasswordController.php
│   │   │   └── ResetPasswordController.php
│   │   ├── DashboardController.php
│   │   ├── RoadmapController.php
│   │   ├── TopicController.php
│   │   ├── ResourceController.php
│   │   ├── ProgressController.php
│   │   └── CertificateController.php
│   ├── Middleware/
│   │   ├── Authenticate.php
│   │   ├── CheckRoadmapOwnership.php
│   │   └── ThrottleApiRequests.php
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
│   │   └── Resource/
│   │       ├── StoreResourceRequest.php
│   │       └── UpdateResourceRequest.php
│   └── Resources/
│       ├── RoadmapResource.php
│       ├── TopicResource.php
│       ├── ResourceResource.php
│       └── CertificateResource.php
├── Models/
│   ├── User.php
│   ├── Roadmap.php
│   ├── Topic.php
│   ├── Resource.php
│   ├── ResourceTag.php
│   ├── TopicProgress.php
│   ├── Certificate.php
│   └── ActivityLog.php
├── Services/
│   ├── Auth/
│   │   ├── AuthService.php
│   │   └── PasswordResetService.php
│   ├── Roadmap/
│   │   ├── RoadmapService.php
│   │   └── RoadmapProgressService.php
│   ├── Topic/
│   │   ├── TopicService.php
│   │   └── TopicProgressService.php
│   ├── Resource/
│   │   └── ResourceService.php
│   ├── Certificate/
│   │   └── CertificateService.php
│   ├── Analytics/
│   │   └── AnalyticsService.php
│   └── File/
│       └── FileUploadService.php
├── Repositories/ (Optional)
│   ├── RoadmapRepository.php
│   ├── TopicRepository.php
│   └── ResourceRepository.php
├── Jobs/
│   ├── GenerateCertificatePdf.php
│   └── SendCertificateEmail.php
├── Events/
│   ├── RoadmapCompleted.php
│   ├── TopicCompleted.php
│   └── CertificateGenerated.php
├── Listeners/
│   ├── UpdateRoadmapProgress.php
│   ├── GenerateCertificate.php
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

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'username',
        'email',
        'password',
        'full_name',
        'profession',
        'bio',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function roadmaps()
    {
        return $this->hasMany(Roadmap::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function topicProgress()
    {
        return $this->hasMany(TopicProgress::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    // Accessors
    public function getProfilePictureUrlAttribute()
    {
        return $this->profile_picture 
            ? Storage::url($this->profile_picture)
            : asset('images/default-avatar.png');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }
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
        'user_id',
        'title',
        'slug',
        'description',
        'category',
        'difficulty_level',
        'target_completion_date',
        'is_public',
        'total_score',
        'progress_percentage',
        'status',
    ];

    protected $casts = [
        'target_completion_date' => 'date',
        'is_public' => 'boolean',
        'total_score' => 'decimal:2',
        'progress_percentage' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Boot method for auto-generating slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($roadmap) {
            if (empty($roadmap->slug)) {
                $roadmap->slug = Str::slug($roadmap->title);
            }
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topics()
    {
        return $this->hasMany(Topic::class)->orderBy('order_index');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    // Accessors
    public function getIsCompletedAttribute()
    {
        return $this->progress_percentage >= 100;
    }

    public function getTotalTopicsAttribute()
    {
        return $this->topics()->count();
    }

    public function getCompletedTopicsAttribute()
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
        'roadmap_id',
        'parent_topic_id',
        'title',
        'description',
        'estimated_hours',
        'difficulty_level',
        'order_index',
        'weight',
        'status',
        'completed_at',
    ];

    protected $casts = [
        'estimated_hours' => 'decimal:2',
        'order_index' => 'integer',
        'weight' => 'integer',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function roadmap()
    {
        return $this->belongsTo(Roadmap::class);
    }

    public function parentTopic()
    {
        return $this->belongsTo(Topic::class, 'parent_topic_id');
    }

    public function subTopics()
    {
        return $this->hasMany(Topic::class, 'parent_topic_id')->orderBy('order_index');
    }

    public function resources()
    {
        return $this->hasMany(Resource::class)->orderBy('order_index');
    }

    public function progress()
    {
        return $this->hasMany(TopicProgress::class);
    }

    // Scopes
    public function scopeRootTopics($query)
    {
        return $query->whereNull('parent_topic_id');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    // Accessors
    public function getIsCompletedAttribute()
    {
        return $this->status === 'completed';
    }

    public function getResourceCountAttribute()
    {
        return $this->resources()->count();
    }
}
```

### Resource Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'resource_type',
        'title',
        'description',
        'content',
        'file_path',
        'file_size',
        'url',
        'is_favorite',
        'order_index',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'is_favorite' => 'boolean',
        'order_index' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function tags()
    {
        return $this->hasMany(ResourceTag::class);
    }

    // Accessors
    public function getFileUrlAttribute()
    {
        return $this->file_path ? Storage::url($this->file_path) : null;
    }

    public function getFileSizeHumanAttribute()
    {
        if (!$this->file_size) return null;

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 2) . ' ' . $units[$unit];
    }

    // Scopes
    public function scopeFavorites($query)
    {
        return $query->where('is_favorite', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('resource_type', $type);
    }
}
```

### Certificate Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'roadmap_id',
        'certificate_number',
        'issued_at',
        'total_topics',
        'total_learning_hours',
        'topics_summary',
        'template_type',
        'file_path',
        'verification_url',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'total_topics' => 'integer',
        'total_learning_hours' => 'decimal:2',
        'topics_summary' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($certificate) {
            if (empty($certificate->uuid)) {
                $certificate->uuid = (string) Str::uuid();
            }
            if (empty($certificate->certificate_number)) {
                $certificate->certificate_number = 'CERT-' . strtoupper(Str::random(10));
            }
            if (empty($certificate->verification_url)) {
                $certificate->verification_url = route('certificate.verify', $certificate->uuid);
            }
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function roadmap()
    {
        return $this->belongsTo(Roadmap::class);
    }

    // Accessors
    public function getDownloadUrlAttribute()
    {
        return route('certificate.download', $this->uuid);
    }

    public function getFileUrlAttribute()
    {
        return $this->file_path ? Storage::url($this->file_path) : null;
    }
}
```

---

## Services Layer

### RoadmapService

```php
<?php

namespace App\Services\Roadmap;

use App\Models\Roadmap;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoadmapService
{
    /**
     * Create a new roadmap
     */
    public function createRoadmap(User $user, array $data): Roadmap
    {
        return DB::transaction(function () use ($user, $data) {
            $roadmap = $user->roadmaps()->create([
                'title' => $data['title'],
                'slug' => $this->generateUniqueSlug($data['title']),
                'description' => $data['description'] ?? null,
                'category' => $data['category'] ?? null,
                'difficulty_level' => $data['difficulty_level'] ?? null,
                'target_completion_date' => $data['target_completion_date'] ?? null,
                'status' => 'active',
                'progress_percentage' => 0,
                'total_score' => 0,
            ]);

            // Log activity
            $this->logActivity($user, 'created_roadmap', $roadmap);

            return $roadmap;
        });
    }

    /**
     * Update roadmap
     */
    public function updateRoadmap(Roadmap $roadmap, array $data): Roadmap
    {
        return DB::transaction(function () use ($roadmap, $data) {
            $roadmap->update([
                'title' => $data['title'] ?? $roadmap->title,
                'description' => $data['description'] ?? $roadmap->description,
                'category' => $data['category'] ?? $roadmap->category,
                'difficulty_level' => $data['difficulty_level'] ?? $roadmap->difficulty_level,
                'target_completion_date' => $data['target_completion_date'] ?? $roadmap->target_completion_date,
            ]);

            return $roadmap->fresh();
        });
    }

    /**
     * Delete roadmap (soft delete)
     */
    public function deleteRoadmap(Roadmap $roadmap): bool
    {
        return DB::transaction(function () use ($roadmap) {
            // Archive associated data
            $roadmap->topics()->delete();
            
            return $roadmap->delete();
        });
    }

    /**
     * Clone a roadmap
     */
    public function cloneRoadmap(Roadmap $sourceRoadmap, User $user): Roadmap
    {
        return DB::transaction(function () use ($sourceRoadmap, $user) {
            $newRoadmap = $this->createRoadmap($user, [
                'title' => $sourceRoadmap->title . ' (Copy)',
                'description' => $sourceRoadmap->description,
                'category' => $sourceRoadmap->category,
                'difficulty_level' => $sourceRoadmap->difficulty_level,
            ]);

            // Clone topics
            foreach ($sourceRoadmap->topics as $topic) {
                $this->cloneTopic($topic, $newRoadmap);
            }

            return $newRoadmap;
        });
    }

    /**
     * Generate shareable link
     */
    public function generateShareableLink(Roadmap $roadmap): string
    {
        $roadmap->update(['is_public' => true]);
        
        return route('roadmap.public', [
            'username' => $roadmap->user->username,
            'slug' => $roadmap->slug
        ]);
    }

    /**
     * Reorder topics
     */
    public function reorderTopics(Roadmap $roadmap, array $topicIds): void
    {
        DB::transaction(function () use ($roadmap, $topicIds) {
            foreach ($topicIds as $index => $topicId) {
                $roadmap->topics()
                    ->where('id', $topicId)
                    ->update(['order_index' => $index]);
            }
        });
    }

    /**
     * Generate unique slug
     */
    private function generateUniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $count = 1;

        while (Roadmap::where('slug', $slug)->exists()) {
            $slug = Str::slug($title) . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     * Clone a topic
     */
    private function cloneTopic($topic, $newRoadmap, $parentId = null): void
    {
        $newTopic = $newRoadmap->topics()->create([
            'parent_topic_id' => $parentId,
            'title' => $topic->title,
            'description' => $topic->description,
            'estimated_hours' => $topic->estimated_hours,
            'difficulty_level' => $topic->difficulty_level,
            'order_index' => $topic->order_index,
            'weight' => $topic->weight,
            'status' => 'not_started',
        ]);

        // Clone sub-topics recursively
        foreach ($topic->subTopics as $subTopic) {
            $this->cloneTopic($subTopic, $newRoadmap, $newTopic->id);
        }
    }

    /**
     * Log user activity
     */
    private function logActivity(User $user, string $action, $model): void
    {
        $user->activityLogs()->create([
            'action_type' => $action,
            'description' => "User {$action} {$model->title}",
            'metadata' => [
                'model_type' => get_class($model),
                'model_id' => $model->id,
            ],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
```

### RoadmapProgressService

```php
<?php

namespace App\Services\Roadmap;

use App\Models\Roadmap;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;

class RoadmapProgressService
{
    /**
     * Calculate and update roadmap progress
     */
    public function calculateProgress(Roadmap $roadmap): void
    {
        DB::transaction(function () use ($roadmap) {
            $topics = $roadmap->topics;
            $totalTopics = $topics->count();

            if ($totalTopics === 0) {
                $roadmap->update([
                    'progress_percentage' => 0,
                    'total_score' => 0,
                ]);
                return;
            }

            $completedTopics = $topics->where('status', 'completed')->count();
            $progressPercentage = ($completedTopics / $totalTopics) * 100;

            // Calculate weighted score
            $totalWeight = $topics->sum('weight');
            $completedWeight = $topics->where('status', 'completed')->sum('weight');
            $score = $totalWeight > 0 ? ($completedWeight / $totalWeight) * 100 : 0;

            $roadmap->update([
                'progress_percentage' => round($progressPercentage, 2),
                'total_score' => round($score, 2),
                'status' => $progressPercentage >= 100 ? 'completed' : 'active',
            ]);

            // Trigger certificate generation if completed
            if ($progressPercentage >= 100 && $roadmap->certificates()->count() === 0) {
                event(new \App\Events\RoadmapCompleted($roadmap));
            }
        });
    }

    /**
     * Get detailed progress statistics
     */
    public function getProgressStats(Roadmap $roadmap): array
    {
        $topics = $roadmap->topics;

        return [
            'total_topics' => $topics->count(),
            'completed_topics' => $topics->where('status', 'completed')->count(),
            'in_progress_topics' => $topics->where('status', 'in_progress')->count(),
            'not_started_topics' => $topics->where('status', 'not_started')->count(),
            'skipped_topics' => $topics->where('status', 'skipped')->count(),
            'progress_percentage' => $roadmap->progress_percentage,
            'total_score' => $roadmap->total_score,
            'estimated_total_hours' => $topics->sum('estimated_hours'),
            'actual_total_hours' => $this->calculateActualHours($roadmap),
        ];
    }

    /**
     * Calculate actual hours spent
     */
    private function calculateActualHours(Roadmap $roadmap): float
    {
        return $roadmap->topics()
            ->with('progress')
            ->get()
            ->flatMap->progress
            ->sum('actual_hours');
    }
}
```

### TopicService

```php
<?php

namespace App\Services\Topic;

use App\Models\Roadmap;
use App\Models\Topic;
use App\Services\Roadmap\RoadmapProgressService;
use Illuminate\Support\Facades\DB;

class TopicService
{
    public function __construct(
        private RoadmapProgressService $progressService
    ) {}

    /**
     * Create a new topic
     */
    public function createTopic(Roadmap $roadmap, array $data): Topic
    {
        return DB::transaction(function () use ($roadmap, $data) {
            $orderIndex = $roadmap->topics()->max('order_index') + 1;

            $topic = $roadmap->topics()->create([
                'parent_topic_id' => $data['parent_topic_id'] ?? null,
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'estimated_hours' => $data['estimated_hours'],
                'difficulty_level' => $data['difficulty_level'] ?? null,
                'order_index' => $orderIndex,
                'weight' => $data['weight'] ?? 1,
                'status' => 'not_started',
            ]);

            $this->progressService->calculateProgress($roadmap);

            return $topic;
        });
    }

    /**
     * Update topic
     */
    public function updateTopic(Topic $topic, array $data): Topic
    {
        return DB::transaction(function () use ($topic, $data) {
            $topic->update($data);

            $this->progressService->calculateProgress($topic->roadmap);

            return $topic->fresh();
        });
    }

    /**
     * Update topic status
     */
    public function updateStatus(Topic $topic, string $status): Topic
    {
        return DB::transaction(function () use ($topic, $status) {
            $updateData = ['status' => $status];

            if ($status === 'completed' && !$topic->completed_at) {
                $updateData['completed_at'] = now();
                event(new \App\Events\TopicCompleted($topic));
            }

            $topic->update($updateData);

            $this->progressService->calculateProgress($topic->roadmap);

            return $topic->fresh();
        });
    }

    /**
     * Delete topic
     */
    public function deleteTopic(Topic $topic): bool
    {
        return DB::transaction(function () use ($topic) {
            $roadmap = $topic->roadmap;

            // Delete all sub-topics recursively
            $this->deleteSubTopics($topic);

            $result = $topic->delete();

            $this->progressService->calculateProgress($roadmap);

            return $result;
        });
    }

    /**
     * Move topic to different roadmap
     */
    public function moveTopic(Topic $topic, Roadmap $targetRoadmap): Topic
    {
        return DB::transaction(function () use ($topic, $targetRoadmap) {
            $oldRoadmap = $topic->roadmap;

            $topic->update([
                'roadmap_id' => $targetRoadmap->id,
                'order_index' => $targetRoadmap->topics()->max('order_index') + 1,
            ]);

            $this->progressService->calculateProgress($oldRoadmap);
            $this->progressService->calculateProgress($targetRoadmap);

            return $topic->fresh();
        });
    }

    /**
     * Delete sub-topics recursively
     */
    private function deleteSubTopics(Topic $topic): void
    {
        foreach ($topic->subTopics as $subTopic) {
            $this->deleteSubTopics($subTopic);
            $subTopic->delete();
        }
    }
}
```

### CertificateService

```php
<?php

namespace App\Services\Certificate;

use App\Models\Certificate;
use App\Models\Roadmap;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CertificateService
{
    /**
     * Generate certificate for completed roadmap
     */
    public function generateCertificate(Roadmap $roadmap, string $templateType = 'modern'): Certificate
    {
        // Verify roadmap is completed
        if ($roadmap->progress_percentage < 100) {
            throw new \Exception('Roadmap must be 100% completed to generate certificate');
        }

        // Check if certificate already exists
        $existingCertificate = $roadmap->certificates()->first();
        if ($existingCertificate) {
            return $existingCertificate;
        }

        $certificate = $this->createCertificate($roadmap, $templateType);
        $this->generatePdf($certificate);

        return $certificate;
    }

    /**
     * Create certificate record
     */
    private function createCertificate(Roadmap $roadmap, string $templateType): Certificate
    {
        $topicsSummary = $roadmap->topics->map(function ($topic) {
            return [
                'title' => $topic->title,
                'completed_at' => $topic->completed_at?->format('Y-m-d'),
                'hours' => $topic->estimated_hours,
            ];
        })->toArray();

        return Certificate::create([
            'user_id' => $roadmap->user_id,
            'roadmap_id' => $roadmap->id,
            'issued_at' => now(),
            'total_topics' => $roadmap->topics()->count(),
            'total_learning_hours' => $roadmap->topics()->sum('estimated_hours'),
            'topics_summary' => $topicsSummary,
            'template_type' => $templateType,
        ]);
    }

    /**
     * Generate PDF
     */
    private function generatePdf(Certificate $certificate): void
    {
        $pdf = Pdf::loadView("certificates.templates.{$certificate->template_type}", [
            'certificate' => $certificate,
            'user' => $certificate->user,
            'roadmap' => $certificate->roadmap,
        ]);

        $filename = "certificate-{$certificate->uuid}.pdf";
        $path = "certificates/{$certificate->user_id}/{$filename}";

        Storage::put($path, $pdf->output());

        $certificate->update(['file_path' => $path]);
    }

    /**
     * Get verification data
     */
    public function verifyCertificate(string $uuid): ?Certificate
    {
        return Certificate::with(['user', 'roadmap'])
            ->where('uuid', $uuid)
            ->first();
    }
}
```

---

## Controllers

### RoadmapController

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\Roadmap\StoreRoadmapRequest;
use App\Http\Requests\Roadmap\UpdateRoadmapRequest;
use App\Models\Roadmap;
use App\Services\Roadmap\RoadmapService;
use App\Services\Roadmap\RoadmapProgressService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoadmapController extends Controller
{
    public function __construct(
        private RoadmapService $roadmapService,
        private RoadmapProgressService $progressService
    ) {
        $this->middleware('auth');
    }

    /**
     * Display listing of roadmaps
     */
    public function index(): View
    {
        $roadmaps = auth()->user()
            ->roadmaps()
            ->with('topics')
            ->latest()
            ->paginate(12);

        return view('roadmaps.index', compact('roadmaps'));
    }

    /**
     * Show create form
     */
    public function create(): View
    {
        return view('roadmaps.create');
    }

    /**
     * Store new roadmap
     */
    public function store(StoreRoadmapRequest $request): RedirectResponse
    {
        $roadmap = $this->roadmapService->createRoadmap(
            auth()->user(),
            $request->validated()
        );

        return redirect()
            ->route('roadmaps.show', $roadmap)
            ->with('success', 'Roadmap created successfully!');
    }

    /**
     * Display roadmap details
     */
    public function show(Roadmap $roadmap): View
    {
        $this->authorize('view', $roadmap);

        $roadmap->load(['topics.resources', 'topics.progress']);
        $stats = $this->progressService->getProgressStats($roadmap);

        return view('roadmaps.show', compact('roadmap', 'stats'));
    }

    /**
     * Show edit form
     */
    public function edit(Roadmap $roadmap): View
    {
        $this->authorize('update', $roadmap);

        return view('roadmaps.edit', compact('roadmap'));
    }

    /**
     * Update roadmap
     */
    public function update(UpdateRoadmapRequest $request, Roadmap $roadmap): RedirectResponse
    {
        $this->authorize('update', $roadmap);

        $this->roadmapService->updateRoadmap($roadmap, $request->validated());

        return redirect()
            ->route('roadmaps.show', $roadmap)
            ->with('success', 'Roadmap updated successfully!');
    }

    /**
     * Delete roadmap
     */
    public function destroy(Roadmap $roadmap): RedirectResponse
    {
        $this->authorize('delete', $roadmap);

        $this->roadmapService->deleteRoadmap($roadmap);

        return redirect()
            ->route('roadmaps.index')
            ->with('success', 'Roadmap deleted successfully!');
    }
}
```

---

## Form Requests & Validation

### StoreRoadmapRequest

```php
<?php

namespace App\Http\Requests\Roadmap;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoadmapRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'category' => 'nullable|string|max:100',
            'difficulty_level' => 'nullable|in:beginner,intermediate,advanced',
            'target_completion_date' => 'nullable|date|after:today',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please provide a title for your roadmap',
            'target_completion_date.after' => 'Target date must be in the future',
        ];
    }
}
```

---

## Database Migrations

### Create Users Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 30)->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('full_name', 100)->nullable();
            $table->string('profession', 100)->nullable();
            $table->text('bio')->nullable();
            $table->string('profile_picture')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
```

### Create Roadmaps Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roadmaps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('category', 100)->nullable();
            $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced'])->nullable();
            $table->date('target_completion_date')->nullable();
            $table->boolean('is_public')->default(false);
            $table->decimal('total_score', 5, 2)->default(0);
            $table->decimal('progress_percentage', 5, 2)->default(0);
            $table->enum('status', ['draft', 'active', 'completed', 'archived'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
            $table->index('is_public');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roadmaps');
    }
};
```

---

## Best Practices

### 1. Service Pattern Guidelines

- **Single Responsibility**: Each service handles one domain
- **Dependency Injection**: Inject dependencies via constructor
- **Return Types**: Always specify return types
- **Type Hints**: Use strict typing for parameters
- **Transactions**: Wrap multi-step operations in DB transactions

### 2. Controller Guidelines

- **Thin Controllers**: Keep controllers thin, delegate to services
- **Authorization**: Use policies for authorization checks
- **Validation**: Use Form Requests for validation
- **RESTful**: Follow RESTful conventions
- **Return Types**: Always specify return types (View, RedirectResponse, JsonResponse)

### 3. Model Guidelines

- **Relationships**: Define all relationships in models
- **Accessors**: Use accessors for computed attributes
- **Scopes**: Use query scopes for reusable queries
- **Casting**: Cast attributes to proper types
- **Mass Assignment**: Protect against mass assignment with $fillable

### 4. Security Guidelines

- **Authorization**: Always check permissions in controllers
- **Validation**: Validate all inputs
- **SQL Injection**: Use Eloquent ORM, never raw queries with user input
- **XSS Prevention**: Blade auto-escapes, use {!! !!} carefully
- **CSRF**: CSRF token on all POST/PUT/DELETE requests

### 5. Testing Guidelines

- **Unit Tests**: Test services and models
- **Feature Tests**: Test complete workflows
- **Database**: Use RefreshDatabase trait
- **Factories**: Use factories for test data
- **Coverage**: Aim for 70%+ code coverage

---

## Conclusion

This backend architecture provides a solid foundation for the Learning Progress Tracker platform. The service pattern ensures separation of concerns, making the codebase maintainable, testable, and scalable. Follow the guidelines and patterns outlined in this document for consistent implementation across the application.

For frontend integration details, refer to `frontend.md`. For day-by-day implementation steps, see the `steps/` directory.
