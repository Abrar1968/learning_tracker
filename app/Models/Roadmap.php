<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roadmap extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'start_date',
        'target_end_date',
        'actual_end_date',
        'progress_percentage',
        'total_topics',
        'completed_topics',
        // New fields
        'is_public',
        'forked_from',
        'fork_count',
        'template_id',
        'view_type',
        'icon',
        'color',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'target_end_date' => 'date',
            'actual_end_date' => 'date',
            'progress_percentage' => 'decimal:2',
            'is_public' => 'boolean',
        ];
    }

    /**
     * Available view types
     */
    public const VIEW_TYPES = [
        'list' => 'List View',
        'kanban' => 'Kanban Board',
        'timeline' => 'Timeline',
        'graph' => 'Graph View',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }

    public function activityLogs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(RoadmapTemplate::class, 'template_id');
    }

    public function forkedFrom(): BelongsTo
    {
        return $this->belongsTo(Roadmap::class, 'forked_from');
    }

    public function forks(): HasMany
    {
        return $this->hasMany(Roadmap::class, 'forked_from');
    }

    public function bookmarks(): MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeNotStarted($query)
    {
        return $query->where('status', 'not_started');
    }

    // Helper Methods
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    public function updateProgress(): void
    {
        $totalTopics = $this->topics()->count();
        $completedTopics = $this->topics()->where('status', 'completed')->count();

        $this->update([
            'total_topics' => $totalTopics,
            'completed_topics' => $completedTopics,
            'progress_percentage' => $totalTopics > 0 ? ($completedTopics / $totalTopics) * 100 : 0,
        ]);
    }

    /**
     * Fork this roadmap for another user
     */
    public function forkForUser(User $user): Roadmap
    {
        $fork = $this->replicate(['user_id', 'fork_count', 'progress_percentage', 'completed_topics', 'status']);
        $fork->user_id = $user->id;
        $fork->forked_from = $this->id;
        $fork->is_public = false;
        $fork->status = 'not_started';
        $fork->progress_percentage = 0;
        $fork->completed_topics = 0;
        $fork->save();

        // Clone topics recursively
        $this->cloneTopicsForFork($fork, $this->topics()->rootTopics()->get());

        // Increment fork count
        $this->increment('fork_count');

        return $fork;
    }

    /**
     * Clone topics recursively for a fork
     */
    protected function cloneTopicsForFork(Roadmap $fork, $topics, ?int $parentId = null): void
    {
        foreach ($topics as $topic) {
            $newTopic = $topic->replicate(['roadmap_id', 'parent_id', 'status', 'actual_hours']);
            $newTopic->roadmap_id = $fork->id;
            $newTopic->parent_id = $parentId;
            $newTopic->status = 'not_started';
            $newTopic->actual_hours = 0;
            $newTopic->save();

            // Clone resources
            foreach ($topic->resources as $resource) {
                $newResource = $resource->replicate(['topic_id', 'user_id', 'is_completed', 'completed_at', 'actual_duration']);
                $newResource->topic_id = $newTopic->id;
                $newResource->user_id = $fork->user_id;
                $newResource->is_completed = false;
                $newResource->completed_at = null;
                $newResource->actual_duration = null;
                $newResource->save();
            }

            // Clone children recursively
            if ($topic->children->isNotEmpty()) {
                $this->cloneTopicsForFork($fork, $topic->children, $newTopic->id);
            }
        }
    }

    /**
     * Scope for public roadmaps
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }
}
