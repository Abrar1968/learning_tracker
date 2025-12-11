<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ActivityLogger
{
    protected ?Model $performedOn = null;
    protected array $properties = [];
    protected ?User $causedBy = null;

    public function performedOn(Model $model): self
    {
        $this->performedOn = $model;
        return $this;
    }

    public function causedBy(?User $user = null): self
    {
        /** @var User|null $authUser */
        $authUser = auth()->user();
        $this->causedBy = $user ?? $authUser;
        return $this;
    }

    public function withProperties(array $properties): self
    {
        $this->properties = $properties;
        return $this;
    }

    public function log(string $action, ?string $description = null): ActivityLog
    {
        /** @var User|null $authUser */
        $authUser = auth()->user();
        $user = $this->causedBy ?? $authUser;

        if (!$user) {
            throw new \Exception('No user found for activity logging');
        }

        return ActivityLog::create([
            'user_id' => $user->id,
            'loggable_type' => $this->performedOn ? get_class($this->performedOn) : null,
            'loggable_id' => $this->performedOn?->id,
            'action' => $action,
            'description' => $description ?? $this->generateDescription($action),
            'metadata' => $this->properties,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    protected function generateDescription(string $action): string
    {
        $descriptions = [
            'roadmap_created' => 'Created a new roadmap',
            'roadmap_updated' => 'Updated roadmap details',
            'roadmap_deleted' => 'Deleted a roadmap',
            'roadmap_started' => 'Started working on roadmap',
            'roadmap_completed' => 'Completed roadmap',
            'topic_created' => 'Created a new topic',
            'topic_updated' => 'Updated topic details',
            'topic_deleted' => 'Deleted a topic',
            'topic_started' => 'Started working on topic',
            'topic_completed' => 'Completed topic',
            'resource_created' => 'Added a new resource',
            'resource_updated' => 'Updated resource details',
            'resource_deleted' => 'Deleted a resource',
            'resource_completed' => 'Completed a resource',
            'certificate_generated' => 'Certificate generated',
            'certificate_deleted' => 'Certificate deleted',
            'topics_reordered' => 'Reordered topics',
        ];

        return $descriptions[$action] ?? ucfirst(str_replace('_', ' ', $action));
    }
}
