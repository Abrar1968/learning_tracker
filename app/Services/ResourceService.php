<?php

namespace App\Services;

use App\Models\Resource;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ResourceService
{
    public function createResource(Topic $topic, User $user, array $data, ?UploadedFile $file = null): Resource
    {
        return DB::transaction(function () use ($topic, $user, $data, $file) {
            $resourceData = [
                'topic_id' => $topic->id,
                'user_id' => $user->id,
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'type' => $data['type'] ?? 'article',
                'url' => $data['url'] ?? null,
                'estimated_duration' => $data['estimated_duration'] ?? null,
            ];

            if ($file) {
                $path = $file->store('resources', 'public');
                $resourceData['file_path'] = $path;
                $resourceData['file_size'] = $file->getSize();
            }

            $resource = Resource::create($resourceData);

            // Add tags if provided
            if (!empty($data['tags'])) {
                $tags = is_array($data['tags']) ? $data['tags'] : explode(',', $data['tags']);
                foreach ($tags as $tag) {
                    $resource->tags()->create(['tag_name' => trim($tag)]);
                }
            }

            activity()
                ->performedOn($resource)
                ->withProperties(['title' => $resource->title, 'type' => $resource->type])
                ->log('resource_created');

            return $resource;
        });
    }

    public function updateResource(Resource $resource, array $data, ?UploadedFile $file = null): Resource
    {
        return DB::transaction(function () use ($resource, $data, $file) {
            if ($file) {
                // Delete old file if exists
                if ($resource->file_path) {
                    Storage::disk('public')->delete($resource->file_path);
                }

                $path = $file->store('resources', 'public');
                $data['file_path'] = $path;
                $data['file_size'] = $file->getSize();
            }

            $resource->update($data);

            // Update tags if provided
            if (isset($data['tags'])) {
                $resource->tags()->delete();
                $tags = is_array($data['tags']) ? $data['tags'] : explode(',', $data['tags']);
                foreach ($tags as $tag) {
                    $resource->tags()->create(['tag_name' => trim($tag)]);
                }
            }

            activity()
                ->performedOn($resource)
                ->log('resource_updated');

            return $resource->fresh();
        });
    }

    public function deleteResource(Resource $resource): bool
    {
        return DB::transaction(function () use ($resource) {
            // Delete file if exists
            if ($resource->file_path) {
                Storage::disk('public')->delete($resource->file_path);
            }

            activity()
                ->performedOn($resource)
                ->withProperties(['title' => $resource->title])
                ->log('resource_deleted');

            return $resource->delete();
        });
    }

    public function markAsCompleted(Resource $resource): Resource
    {
        $resource->update([
            'is_completed' => true,
            'completed_at' => now(),
        ]);

        activity()
            ->performedOn($resource)
            ->log('resource_completed');

        return $resource;
    }
}
