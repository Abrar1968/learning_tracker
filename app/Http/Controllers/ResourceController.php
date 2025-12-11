<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Models\Resource;
use App\Models\Topic;
use App\Services\ResourceService;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function __construct(
        protected ResourceService $resourceService
    ) {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Topic $topic)
    {
        $resources = $topic->resources()->with('tags')->get();

        return view('resources.index', compact('topic', 'resources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Topic $topic)
    {
        return view('resources.create', compact('topic'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResourceRequest $request, Topic $topic)
    {
        $resource = $this->resourceService->createResource(
            $topic,
            $request->user(),
            $request->validated(),
            $request->file('file')
        );

        return redirect()
            ->route('topics.show', [$topic->roadmap, $topic])
            ->with('success', 'Resource added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Resource $resource)
    {
        $resource->load('tags');

        return view('resources.show', compact('resource'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resource $resource)
    {
        return view('resources.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResourceRequest $request, Resource $resource)
    {
        $resource = $this->resourceService->updateResource(
            $resource,
            $request->validated(),
            $request->file('file')
        );

        return redirect()
            ->route('resources.show', $resource)
            ->with('success', 'Resource updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        $topic = $resource->topic;
        $this->resourceService->deleteResource($resource);

        return redirect()
            ->route('topics.show', [$topic->roadmap, $topic])
            ->with('success', 'Resource deleted successfully!');
    }
}
