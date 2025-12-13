<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Topic;
use App\Models\Resource;
use App\Models\Roadmap;
use App\Services\BookmarkService;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function __construct(
        protected BookmarkService $bookmarkService
    ) {}

    /**
     * Display all bookmarks
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $folder = $request->query('folder');
        $type = $request->query('type');

        $bookmarks = $this->bookmarkService->getBookmarks($user, $folder, $type);
        $folders = $this->bookmarkService->getFolders($user);
        $counts = $this->bookmarkService->getCounts($user);

        return view('bookmarks.index', compact('bookmarks', 'folders', 'counts', 'folder', 'type'));
    }

    /**
     * Toggle bookmark for a topic
     */
    public function toggleTopic(Request $request, Topic $topic)
    {
        $validated = $request->validate([
            'folder' => 'sometimes|string|max:100',
            'notes' => 'sometimes|string|max:500',
        ]);

        $isBookmarked = $this->bookmarkService->toggle(
            auth()->user(),
            $topic,
            $validated['folder'] ?? null,
            $validated['notes'] ?? null
        );

        if ($request->wantsJson()) {
            return response()->json([
                'bookmarked' => $isBookmarked,
                'message' => $isBookmarked ? 'Topic bookmarked' : 'Bookmark removed',
            ]);
        }

        return redirect()->back()->with(
            'success',
            $isBookmarked ? 'Topic bookmarked!' : 'Bookmark removed!'
        );
    }

    /**
     * Toggle bookmark for a resource
     */
    public function toggleResource(Request $request, Resource $resource)
    {
        $validated = $request->validate([
            'folder' => 'sometimes|string|max:100',
            'notes' => 'sometimes|string|max:500',
        ]);

        $isBookmarked = $this->bookmarkService->toggle(
            auth()->user(),
            $resource,
            $validated['folder'] ?? null,
            $validated['notes'] ?? null
        );

        if ($request->wantsJson()) {
            return response()->json([
                'bookmarked' => $isBookmarked,
                'message' => $isBookmarked ? 'Resource bookmarked' : 'Bookmark removed',
            ]);
        }

        return redirect()->back()->with(
            'success',
            $isBookmarked ? 'Resource bookmarked!' : 'Bookmark removed!'
        );
    }

    /**
     * Toggle bookmark for a roadmap
     */
    public function toggleRoadmap(Request $request, Roadmap $roadmap)
    {
        $validated = $request->validate([
            'folder' => 'sometimes|string|max:100',
            'notes' => 'sometimes|string|max:500',
        ]);

        $isBookmarked = $this->bookmarkService->toggle(
            auth()->user(),
            $roadmap,
            $validated['folder'] ?? null,
            $validated['notes'] ?? null
        );

        if ($request->wantsJson()) {
            return response()->json([
                'bookmarked' => $isBookmarked,
                'message' => $isBookmarked ? 'Roadmap bookmarked' : 'Bookmark removed',
            ]);
        }

        return redirect()->back()->with(
            'success',
            $isBookmarked ? 'Roadmap bookmarked!' : 'Bookmark removed!'
        );
    }

    /**
     * Update bookmark details
     */
    public function update(Request $request, Bookmark $bookmark)
    {
        if ($bookmark->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'folder' => 'sometimes|nullable|string|max:100',
            'notes' => 'sometimes|nullable|string|max:500',
        ]);

        if (array_key_exists('folder', $validated)) {
            $this->bookmarkService->moveToFolder($bookmark, $validated['folder']);
        }

        if (array_key_exists('notes', $validated)) {
            $this->bookmarkService->updateNotes($bookmark, $validated['notes']);
        }

        return redirect()->back()->with('success', 'Bookmark updated!');
    }

    /**
     * Delete a bookmark
     */
    public function destroy(Bookmark $bookmark)
    {
        if ($bookmark->user_id !== auth()->id()) {
            abort(403);
        }

        $bookmark->delete();

        return redirect()->back()->with('success', 'Bookmark removed!');
    }
}
