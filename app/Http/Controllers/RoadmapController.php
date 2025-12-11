<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoadmapRequest;
use App\Http\Requests\UpdateRoadmapRequest;
use App\Models\Roadmap;
use App\Services\RoadmapService;
use Illuminate\Http\Request;

class RoadmapController extends Controller
{
    public function __construct(
        protected RoadmapService $roadmapService
    ) {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $roadmaps = $this->roadmapService->getUserRoadmaps(
            $request->user(),
            $status
        );

        return view('roadmaps.index', compact('roadmaps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roadmaps.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoadmapRequest $request)
    {
        $roadmap = $this->roadmapService->createRoadmap(
            $request->user(),
            $request->validated()
        );

        return redirect()
            ->route('roadmaps.show', $roadmap)
            ->with('success', 'Roadmap created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Roadmap $roadmap)
    {
        $this->authorize('view', $roadmap);

        $roadmap->load(['topics' => function ($query) {
            $query->rootTopics()->ordered()->with('children');
        }]);

        $progress = $this->roadmapService->calculateProgress($roadmap);

        return view('roadmaps.show', compact('roadmap', 'progress'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Roadmap $roadmap)
    {
        $this->authorize('update', $roadmap);

        return view('roadmaps.edit', compact('roadmap'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoadmapRequest $request, Roadmap $roadmap)
    {
        $roadmap = $this->roadmapService->updateRoadmap(
            $roadmap,
            $request->validated()
        );

        return redirect()
            ->route('roadmaps.show', $roadmap)
            ->with('success', 'Roadmap updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Roadmap $roadmap)
    {
        $this->authorize('delete', $roadmap);

        $this->roadmapService->deleteRoadmap($roadmap);

        return redirect()
            ->route('roadmaps.index')
            ->with('success', 'Roadmap deleted successfully!');
    }
}
