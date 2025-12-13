<?php

namespace App\Services;

use App\Models\RoadmapTemplate;
use App\Models\User;
use App\Models\Roadmap;
use Illuminate\Support\Str;

class TemplateService
{
    /**
     * Get featured templates
     */
    public function getFeaturedTemplates(int $limit = 6): \Illuminate\Database\Eloquent\Collection
    {
        return RoadmapTemplate::where('is_active', true)
            ->where('is_featured', true)
            ->orderByDesc('clone_count')
            ->limit($limit)
            ->get();
    }

    /**
     * Get templates by category
     */
    public function getByCategory(string $category): \Illuminate\Database\Eloquent\Collection
    {
        return RoadmapTemplate::where('is_active', true)
            ->where('category', $category)
            ->orderByDesc('rating')
            ->get();
    }

    /**
     * Search templates
     */
    public function search(string $query, ?string $category = null, ?string $difficulty = null): \Illuminate\Database\Eloquent\Collection
    {
        $q = RoadmapTemplate::where('is_active', true);

        if ($query) {
            $q->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            });
        }

        if ($category) {
            $q->where('category', $category);
        }

        if ($difficulty) {
            $q->where('difficulty', $difficulty);
        }

        return $q->orderByDesc('rating')->get();
    }

    /**
     * Clone a template for a user
     */
    public function cloneForUser(RoadmapTemplate $template, User $user): Roadmap
    {
        return $template->cloneForUser($user);
    }

    /**
     * Create a template from an existing roadmap
     */
    public function createFromRoadmap(
        Roadmap $roadmap,
        string $name,
        ?string $description = null,
        ?string $category = null,
        string $difficulty = 'intermediate'
    ): RoadmapTemplate {
        $structure = $this->extractStructure($roadmap);

        return RoadmapTemplate::create([
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $description ?? $roadmap->description,
            'category' => $category,
            'difficulty' => $difficulty,
            'estimated_hours' => $roadmap->topics->sum('estimated_hours'),
            'structure' => $structure,
            'icon' => $roadmap->icon,
            'color' => $roadmap->color,
            'created_by' => $roadmap->user_id,
        ]);
    }

    /**
     * Extract roadmap structure for template
     */
    protected function extractStructure(Roadmap $roadmap): array
    {
        return $this->extractTopicsStructure($roadmap->topics()->rootTopics()->ordered()->get());
    }

    /**
     * Recursively extract topics structure
     */
    protected function extractTopicsStructure($topics): array
    {
        $structure = [];

        foreach ($topics as $topic) {
            $topicData = [
                'title' => $topic->title,
                'description' => $topic->description,
                'estimated_hours' => $topic->estimated_hours,
                'skill_category' => $topic->skill_category,
                'icon' => $topic->icon,
                'color' => $topic->color,
            ];

            // Extract resources
            $resources = [];
            foreach ($topic->resources as $resource) {
                $resources[] = [
                    'title' => $resource->title,
                    'description' => $resource->description,
                    'type' => $resource->type,
                    'url' => $resource->url,
                    'estimated_duration' => $resource->estimated_duration,
                    'difficulty' => $resource->difficulty,
                ];
            }

            if (!empty($resources)) {
                $topicData['resources'] = $resources;
            }

            // Recursively get children
            if ($topic->children->isNotEmpty()) {
                $topicData['children'] = $this->extractTopicsStructure($topic->children);
            }

            $structure[] = $topicData;
        }

        return $structure;
    }

    /**
     * Rate a template
     */
    public function rateTemplate(RoadmapTemplate $template, int $rating): void
    {
        $newCount = $template->rating_count + 1;
        $newRating = (($template->rating * $template->rating_count) + $rating) / $newCount;

        $template->update([
            'rating' => round($newRating, 2),
            'rating_count' => $newCount,
        ]);
    }

    /**
     * Get all categories with counts
     */
    public function getCategoriesWithCounts(): array
    {
        $templates = RoadmapTemplate::where('is_active', true)->get();
        
        $counts = [];
        foreach (RoadmapTemplate::CATEGORIES as $key => $name) {
            $counts[$key] = [
                'name' => $name,
                'count' => $templates->where('category', $key)->count(),
            ];
        }

        return $counts;
    }
}
