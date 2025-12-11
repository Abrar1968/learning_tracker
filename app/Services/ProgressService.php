<?php

namespace App\Services;

use App\Models\Topic;
use App\Models\TopicProgress;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProgressService
{
    public function startTopic(Topic $topic, User $user): TopicProgress
    {
        return DB::transaction(function () use ($topic, $user) {
            $progress = TopicProgress::updateOrCreate(
                [
                    'topic_id' => $topic->id,
                    'user_id' => $user->id,
                ],
                [
                    'started_at' => now(),
                    'total_resources' => $topic->resources()->count(),
                ]
            );

            $topic->update(['status' => 'in_progress']);

            activity()
                ->performedOn($topic)
                ->log('topic_started');

            return $progress;
        });
    }

    public function updateProgress(TopicProgress $progress, array $data): TopicProgress
    {
        $progress->update($data);

        return $progress;
    }

    public function addTimeSpent(TopicProgress $progress, int $minutes): TopicProgress
    {
        $progress->addTimeSpent($minutes);

        return $progress;
    }

    public function completeTopic(TopicProgress $progress): TopicProgress
    {
        return DB::transaction(function () use ($progress) {
            $progress->update([
                'completed_at' => now(),
                'resources_completed' => $progress->total_resources,
            ]);

            $progress->topic->update(['status' => 'completed']);
            $progress->topic->roadmap->updateProgress();

            activity()
                ->performedOn($progress->topic)
                ->withProperties(['time_spent' => $progress->time_spent])
                ->log('topic_completed');

            return $progress;
        });
    }

    public function addNotes(TopicProgress $progress, string $notes): TopicProgress
    {
        $progress->update(['notes' => $notes]);

        return $progress;
    }

    public function logTime(TopicProgress $progress, int $minutes): TopicProgress
    {
        return $this->addTimeSpent($progress, $minutes);
    }
}
