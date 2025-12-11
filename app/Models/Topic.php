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
    ];

    protected function casts(): array
    {
        return [
            'weightage' => 'decimal:2',
        ];
    }

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
}
