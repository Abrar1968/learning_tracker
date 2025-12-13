<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'roadmap_id',
        'parent_id',
        'title',
        'description',
        'status',
        'order',
        'estimated_hours',
        'actual_hours',
        'weightage',
        // New fields
        'skill_category',
        'notes',
        'icon',
        'color',
        'position_x',
        'position_y',
    ];

    protected function casts(): array
    {
        return [
            'weightage' => 'decimal:2',
            'actual_hours' => 'decimal:2',
        ];
    }

    /**
     * Skill categories for radar chart
     */
    public const SKILL_CATEGORIES = [
        'frontend' => 'Frontend',
        'backend' => 'Backend',
        'database' => 'Database',
        'devops' => 'DevOps',
        'testing' => 'Testing',
        'architecture' => 'Architecture',
        'security' => 'Security',
        'mobile' => 'Mobile',
        'ai-ml' => 'AI/ML',
        'other' => 'Other',
    ];

    // Relationships
    public function roadmap(): BelongsTo
    {
        return $this->belongsTo(Roadmap::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Topic::class, 'parent_id');
    }

    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }

    public function progress(): HasOne
    {
        return $this->hasOne(TopicProgress::class);
    }

    public function activityLogs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function dependencies(): HasMany
    {
        return $this->hasMany(TopicDependency::class);
    }

    public function dependsOn(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Topic::class, 'topic_dependencies', 'topic_id', 'depends_on_topic_id')
            ->withPivot('is_required')
            ->withTimestamps();
    }

    public function dependedOnBy(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Topic::class, 'topic_dependencies', 'depends_on_topic_id', 'topic_id')
            ->withPivot('is_required')
            ->withTimestamps();
    }

    public function bookmarks(): MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function reviewSchedules(): HasMany
    {
        return $this->hasMany(ReviewSchedule::class);
    }

    public function focusSessions(): HasMany
    {
        return $this->hasMany(FocusSession::class);
    }

    // Scopes
    public function scopeRootTopics($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Helper Methods
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    public function markAsCompleted(): void
    {
        $this->update(['status' => 'completed']);
        $this->roadmap->updateProgress();
    }

    /**
     * Check if all dependencies are completed
     */
    public function areDependenciesMet(): bool
    {
        return $this->dependsOn()
            ->wherePivot('is_required', true)
            ->where('status', '!=', 'completed')
            ->doesntExist();
    }

    /**
     * Get all ancestor topics (for breadcrumbs)
     */
    public function getAncestors(): \Illuminate\Support\Collection
    {
        $ancestors = collect();
        $parent = $this->parent;
        
        while ($parent) {
            $ancestors->prepend($parent);
            $parent = $parent->parent;
        }
        
        return $ancestors;
    }

    /**
     * Get all descendant topic IDs (for bulk operations)
     */
    public function getDescendantIds(): array
    {
        $ids = [];
        
        foreach ($this->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $child->getDescendantIds());
        }
        
        return $ids;
    }
}
