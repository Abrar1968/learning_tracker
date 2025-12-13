<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'topic_id',
        'user_id',
        'title',
        'description',
        'type',
        'url',
        'file_path',
        'file_size',
        'estimated_duration',
        'is_completed',
        'completed_at',
        // New fields
        'rating',
        'difficulty',
        'actual_duration',
        'author',
        'source',
        'priority',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'is_completed' => 'boolean',
            'completed_at' => 'datetime',
            'rating' => 'decimal:1',
        ];
    }

    /**
     * Resource types (enhanced)
     */
    public const TYPES = [
        'video' => ['name' => 'Video', 'icon' => '🎥'],
        'article' => ['name' => 'Article', 'icon' => '📄'],
        'book' => ['name' => 'Book', 'icon' => '📚'],
        'course' => ['name' => 'Course', 'icon' => '🎓'],
        'documentation' => ['name' => 'Documentation', 'icon' => '📋'],
        'podcast' => ['name' => 'Podcast', 'icon' => '🎧'],
        'github' => ['name' => 'GitHub Repo', 'icon' => '💻'],
        'tutorial' => ['name' => 'Tutorial', 'icon' => '📝'],
        'tool' => ['name' => 'Tool', 'icon' => '🔧'],
        'other' => ['name' => 'Other', 'icon' => '📎'],
    ];

    /**
     * Difficulty levels
     */
    public const DIFFICULTIES = [
        'beginner' => 'Beginner',
        'intermediate' => 'Intermediate',
        'advanced' => 'Advanced',
    ];

    // Relationships
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(ResourceTag::class);
    }

    public function activityLogs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
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
    public function scopeCompleted($query)
    {
        return $query->where('is_completed', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    // Helper Methods
    public function getFileSizeFormatted(): string
    {
        if (!$this->file_size) {
            return 'N/A';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $size = $this->file_size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 2) . ' ' . $units[$unit];
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'is_completed' => true,
            'completed_at' => now(),
        ]);
    }

    /**
     * Get type icon
     */
    public function getTypeIconAttribute(): string
    {
        return self::TYPES[$this->type]['icon'] ?? '📎';
    }

    /**
     * Get type name
     */
    public function getTypeNameAttribute(): string
    {
        return self::TYPES[$this->type]['name'] ?? 'Other';
    }

    /**
     * Scope by difficulty
     */
    public function scopeByDifficulty($query, string $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    /**
     * Scope by priority
     */
    public function scopeOrdered($query)
    {
        return $query->orderByDesc('priority')->orderBy('created_at');
    }
}
