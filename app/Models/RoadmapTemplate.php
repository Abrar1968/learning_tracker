<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoadmapTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'difficulty',
        'estimated_hours',
        'structure',
        'icon',
        'color',
        'is_featured',
        'is_active',
        'created_by',
        'clone_count',
        'rating',
        'rating_count',
    ];

    protected function casts(): array
    {
        return [
            'structure' => 'array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'rating' => 'decimal:2',
        ];
    }

    /**
     * Template categories
     */
    public const CATEGORIES = [
        'programming' => 'Programming',
        'web-development' => 'Web Development',
        'mobile-development' => 'Mobile Development',
        'data-science' => 'Data Science',
        'machine-learning' => 'Machine Learning',
        'devops' => 'DevOps',
        'design' => 'Design',
        'business' => 'Business',
        'language' => 'Language Learning',
        'other' => 'Other',
    ];

    /**
     * Category icons
     */
    public const CATEGORY_ICONS = [
        'programming' => '💻',
        'web-development' => '🌐',
        'mobile-development' => '📱',
        'data-science' => '📊',
        'machine-learning' => '🤖',
        'devops' => '⚙️',
        'design' => '🎨',
        'business' => '💼',
        'language' => '🗣️',
        'other' => '📁',
    ];

    /**
     * Difficulty levels
     */
    public const DIFFICULTIES = [
        'beginner' => 'Beginner',
        'intermediate' => 'Intermediate',
        'advanced' => 'Advanced',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function roadmaps(): HasMany
    {
        return $this->hasMany(Roadmap::class, 'template_id');
    }

    /**
     * Clone this template to create a new roadmap for a user
     */
    public function cloneForUser(User $user): Roadmap
    {
        $roadmap = Roadmap::create([
            'user_id' => $user->id,
            'title' => $this->name,
            'description' => $this->description,
            'template_id' => $this->id,
            'icon' => $this->icon,
            'color' => $this->color,
        ]);

        // Create topics from structure
        $this->createTopicsFromStructure($roadmap, $this->structure);

        // Increment clone count
        $this->increment('clone_count');

        return $roadmap;
    }

    /**
     * Recursively create topics from structure
     */
    protected function createTopicsFromStructure(Roadmap $roadmap, array $topics, ?int $parentId = null): void
    {
        foreach ($topics as $index => $topicData) {
            $topic = $roadmap->topics()->create([
                'title' => $topicData['title'],
                'description' => $topicData['description'] ?? null,
                'parent_id' => $parentId,
                'order' => $index,
                'estimated_hours' => $topicData['estimated_hours'] ?? 0,
                'skill_category' => $topicData['skill_category'] ?? null,
                'icon' => $topicData['icon'] ?? null,
                'color' => $topicData['color'] ?? null,
            ]);

            // Create resources if any
            if (!empty($topicData['resources'])) {
                foreach ($topicData['resources'] as $resourceData) {
                    $topic->resources()->create([
                        'user_id' => $roadmap->user_id,
                        'title' => $resourceData['title'],
                        'description' => $resourceData['description'] ?? null,
                        'type' => $resourceData['type'] ?? 'article',
                        'url' => $resourceData['url'] ?? null,
                        'estimated_duration' => $resourceData['estimated_duration'] ?? null,
                        'difficulty' => $resourceData['difficulty'] ?? null,
                    ]);
                }
            }

            // Recursively create children
            if (!empty($topicData['children'])) {
                $this->createTopicsFromStructure($roadmap, $topicData['children'], $topic->id);
            }
        }
    }
}
