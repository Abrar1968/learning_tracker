<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Models\Resource;
use App\Models\Topic;
use App\Services\ResourceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ResourceController extends Controller
{
    public function __construct(
        protected ResourceService $resourceService
    ) {
        //
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
    public function create(?Topic $topic = null, Request $request)
    {
        // Handle standalone route with topic_id query parameter
        if (!$topic && $request->has('topic_id')) {
            $topic = Topic::findOrFail($request->query('topic_id'));
        }

        if (!$topic) {
            return redirect()->route('roadmaps.index')->with('error', 'Please select a topic first.');
        }

        Gate::authorize('update', $topic);
        return view('resources.create', compact('topic'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResourceRequest $request, ?Topic $topic = null)
    {
        // Handle standalone route with topic_id in request data
        if (!$topic && $request->has('topic_id')) {
            $topic = Topic::findOrFail($request->input('topic_id'));
        }

        if (!$topic) {
            return redirect()->back()->with('error', 'Topic not found.');
        }

        Gate::authorize('update', $topic);

        $resource = $this->resourceService->createResource(
            $topic,
            $request->user(),
            $request->validated(),
            $request->file('file')
        );

        return redirect()
            ->route('topics.show', $topic)
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
    public function edit(?Topic $topic = null, ?Resource $resource = null)
    {
        // Handle standalone route where first param is actually the resource
        if ($topic instanceof Resource) {
            $resource = $topic;
            $topic = $resource->topic;
        }

        Gate::authorize('update', $resource);
        return view('resources.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResourceRequest $request, ?Topic $topic = null, ?Resource $resource = null)
    {
        // Handle standalone route where first param is actually the resource
        if ($topic instanceof Resource) {
            $resource = $topic;
        }

        Gate::authorize('update', $resource);

        $resource = $this->resourceService->updateResource(
            $resource,
            $request->validated(),
            $request->file('file')
        );

        return redirect()
            ->route('topics.show', $resource->topic)
            ->with('success', 'Resource updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(?Topic $topic = null, ?Resource $resource = null)
    {
        // Handle standalone route where first param is actually the resource
        if ($topic instanceof Resource) {
            $resource = $topic;
            $topic = $resource->topic;
        }

        Gate::authorize('delete', $resource);

        $this->resourceService->deleteResource($resource);

        return redirect()
            ->route('topics.show', $topic)
            ->with('success', 'Resource deleted successfully!');
    }
}
