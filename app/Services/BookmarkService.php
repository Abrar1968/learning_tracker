<?php

namespace App\Services;

use App\Models\Bookmark;
use App\Models\User;
use App\Models\Topic;
use App\Models\Resource;
use App\Models\Roadmap;

class BookmarkService
{
    /**
     * Toggle bookmark for an item
     */
    public function toggle(User $user, Topic|Resource|Roadmap $item, ?string $folder = null, ?string $notes = null): bool
    {
        $existing = $this->findBookmark($user, $item);

        if ($existing) {
            $existing->delete();
            return false; // Unbookmarked
        }

        Bookmark::create([
            'user_id' => $user->id,
            'bookmarkable_type' => get_class($item),
            'bookmarkable_id' => $item->id,
            'folder' => $folder,
            'notes' => $notes,
        ]);

        return true; // Bookmarked
    }

    /**
     * Check if item is bookmarked
     */
    public function isBookmarked(User $user, Topic|Resource|Roadmap $item): bool
    {
        return $this->findBookmark($user, $item) !== null;
    }

    /**
     * Find bookmark for an item
     */
    protected function findBookmark(User $user, Topic|Resource|Roadmap $item): ?Bookmark
    {
        return Bookmark::where('user_id', $user->id)
            ->where('bookmarkable_type', get_class($item))
            ->where('bookmarkable_id', $item->id)
            ->first();
    }

    /**
     * Get all bookmarks for a user
     */
    public function getBookmarks(User $user, ?string $folder = null, ?string $type = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = Bookmark::with('bookmarkable')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        if ($folder !== null) {
            $query->inFolder($folder);
        }

        if ($type) {
            $modelClass = match ($type) {
                'topic' => Topic::class,
                'resource' => Resource::class,
                'roadmap' => Roadmap::class,
                default => null,
            };

            if ($modelClass) {
                $query->where('bookmarkable_type', $modelClass);
            }
        }

        return $query->get();
    }

    /**
     * Get all folders for a user
     */
    public function getFolders(User $user): array
    {
        return Bookmark::getFoldersForUser($user->id);
    }

    /**
     * Move bookmark to a folder
     */
    public function moveToFolder(Bookmark $bookmark, ?string $folder): void
    {
        $bookmark->update(['folder' => $folder]);
    }

    /**
     * Update bookmark notes
     */
    public function updateNotes(Bookmark $bookmark, ?string $notes): void
    {
        $bookmark->update(['notes' => $notes]);
    }

    /**
     * Get bookmark counts by type
     */
    public function getCounts(User $user): array
    {
        $bookmarks = Bookmark::where('user_id', $user->id)->get();

        return [
            'total' => $bookmarks->count(),
            'topics' => $bookmarks->where('bookmarkable_type', Topic::class)->count(),
            'resources' => $bookmarks->where('bookmarkable_type', Resource::class)->count(),
            'roadmaps' => $bookmarks->where('bookmarkable_type', Roadmap::class)->count(),
            'folders' => count($this->getFolders($user)),
        ];
    }
}
