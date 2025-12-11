<?php

namespace App\Services;

use App\Models\Roadmap;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;

class TopicService
{
    public function createTopic(Roadmap $roadmap, array $data): Topic
    {
        return DB::transaction(function () use ($roadmap, $data) {
            $maxOrder = $roadmap->topics()->max('order') ?? 0;

            $topic = $roadmap->topics()->create([
                'parent_id' => $data['parent_id'] ?? null,
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'order' => $data['order'] ?? ($maxOrder + 1),
                'estimated_hours' => $data['estimated_hours'] ?? 0,
                'weightage' => $data['weightage'] ?? 0,
            ]);

            $roadmap->updateProgress();

            activity()
                ->performedOn($topic)
                ->withProperties(['title' => $topic->title, 'roadmap' => $roadmap->title])
                ->log('topic_created');

            return $topic;
        });
    }

    public function updateTopic(Topic $topic, array $data): Topic
    {
        return DB::transaction(function () use ($topic, $data) {
            $topic->update($data);

            $topic->roadmap->updateProgress();

            activity()
                ->performedOn($topic)
                ->log('topic_updated');

            return $topic->fresh();
        });
    }

    public function deleteTopic(Topic $topic): bool
    {
        return DB::transaction(function () use ($topic) {
            $roadmap = $topic->roadmap;

            activity()
                ->performedOn($topic)
                ->withProperties(['title' => $topic->title])
                ->log('topic_deleted');

            $result = $topic->delete();

            $roadmap->updateProgress();

            return $result;
        });
    }

    public function reorderTopics(Roadmap $roadmap, array $topicIds): void
    {
        DB::transaction(function () use ($roadmap, $topicIds) {
            foreach ($topicIds as $index => $topicId) {
                $roadmap->topics()->where('id', $topicId)->update(['order' => $index + 1]);
            }

            activity()
                ->performedOn($roadmap)
                ->withProperties(['topic_count' => count($topicIds)])
                ->log('topics_reordered');
        });
    }

    public function completeTopic(Topic $topic): Topic
    {
        return DB::transaction(function () use ($topic) {
            $topic->update(['status' => 'completed']);

            $topic->roadmap->updateProgress();

            activity()
                ->performedOn($topic)
                ->log('topic_completed');

            return $topic;
        });
    }
}
