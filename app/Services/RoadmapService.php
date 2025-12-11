<?php

namespace App\Services;

use App\Models\Roadmap;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RoadmapService
{
    public function createRoadmap(User $user, array $data): Roadmap
    {
        return DB::transaction(function () use ($user, $data) {
            $roadmap = $user->roadmaps()->create([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'status' => 'not_started',
                'start_date' => $data['start_date'] ?? null,
                'target_end_date' => $data['target_end_date'] ?? null,
            ]);

            activity()
                ->performedOn($roadmap)
                ->withProperties(['title' => $roadmap->title])
                ->log('roadmap_created');

            return $roadmap;
        });
    }

    public function updateRoadmap(Roadmap $roadmap, array $data): Roadmap
    {
        return DB::transaction(function () use ($roadmap, $data) {
            $oldTitle = $roadmap->title;

            $roadmap->update($data);

            activity()
                ->performedOn($roadmap)
                ->withProperties(['old_title' => $oldTitle, 'new_title' => $roadmap->title])
                ->log('roadmap_updated');

            return $roadmap->fresh();
        });
    }

    public function deleteRoadmap(Roadmap $roadmap): bool
    {
        return DB::transaction(function () use ($roadmap) {
            activity()
                ->performedOn($roadmap)
                ->withProperties(['title' => $roadmap->title])
                ->log('roadmap_deleted');

            return $roadmap->delete();
        });
    }

    public function startRoadmap(Roadmap $roadmap): Roadmap
    {
        $roadmap->update([
            'status' => 'in_progress',
            'start_date' => $roadmap->start_date ?? now(),
        ]);

        activity()
            ->performedOn($roadmap)
            ->log('roadmap_started');

        return $roadmap;
    }

    public function completeRoadmap(Roadmap $roadmap): Roadmap
    {
        $roadmap->update([
            'status' => 'completed',
            'actual_end_date' => now(),
            'progress_percentage' => 100,
        ]);

        activity()
            ->performedOn($roadmap)
            ->log('roadmap_completed');

        return $roadmap;
    }

    public function getUserRoadmaps(User $user, array $filters = [])
    {
        $query = $user->roadmaps()->with(['topics', 'certificate']);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->latest()->paginate($filters['per_page'] ?? 10);
    }

    public function calculateProgress(Roadmap $roadmap): array
    {
        $totalTopics = $roadmap->topics()->count();
        $completedTopics = $roadmap->topics()->where('status', 'completed')->count();
        $inProgressTopics = $roadmap->topics()->where('status', 'in_progress')->count();

        $progressPercentage = $totalTopics > 0 ? ($completedTopics / $totalTopics) * 100 : 0;

        // Update roadmap progress
        $roadmap->update([
            'progress_percentage' => $progressPercentage,
            'total_topics' => $totalTopics,
            'completed_topics' => $completedTopics,
        ]);

        return [
            'total_topics' => $totalTopics,
            'completed_topics' => $completedTopics,
            'in_progress_topics' => $inProgressTopics,
            'not_started_topics' => $totalTopics - $completedTopics - $inProgressTopics,
            'progress_percentage' => round($progressPercentage, 2),
        ];
    }
}
