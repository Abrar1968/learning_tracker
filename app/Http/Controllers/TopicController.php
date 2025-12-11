<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Roadmap;
use App\Models\Topic;
use App\Services\AttachmentService;
use App\Services\TopicService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TopicController extends Controller
{
    public function __construct(
        protected TopicService $topicService,
        protected AttachmentService $attachmentService
    ) {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Roadmap $roadmap)
    {
        $topics = $roadmap->topics()
            ->rootTopics()
            ->ordered()
            ->with('children')
            ->get();

        return view('topics.index', compact('roadmap', 'topics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Roadmap $roadmap)
    {
        $parentTopics = $roadmap->topics()->rootTopics()->get();

        return view('topics.create', compact('roadmap', 'parentTopics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTopicRequest $request, Roadmap $roadmap)
    {
        $topic = $this->topicService->createTopic(
            $roadmap,
            $request->validated()
        );

        // Handle file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $this->attachmentService->attachFile($topic, $file, $request->user()->id);
            }
        }

        return redirect()
            ->route('roadmaps.show', $roadmap)
            ->with('success', 'Topic created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(?Roadmap $roadmap, ?Topic $topic = null)
    {
        // Handle standalone route where first param is actually the topic
        if ($roadmap instanceof Topic) {
            $topic = $roadmap;
            $roadmap = $topic->roadmap;
        }

        Gate::authorize('view', $topic);
        $topic->load(['resources', 'progress']);

        return view('topics.show', compact('roadmap', 'topic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Roadmap $roadmap, Topic $topic)
    {
        $parentTopics = $roadmap->topics()
            ->rootTopics()
            ->where('id', '!=', $topic->id)
            ->get();

        return view('topics.edit', compact('roadmap', 'topic', 'parentTopics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTopicRequest $request, Roadmap $roadmap, Topic $topic)
    {
        $topic = $this->topicService->updateTopic(
            $topic,
            $request->validated()
        );

        // Handle file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $this->attachmentService->attachFile($topic, $file, $request->user()->id);
            }
        }

        return redirect()
            ->route('topics.show', [$roadmap, $topic])
            ->with('success', 'Topic updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(?Roadmap $roadmap, ?Topic $topic = null)
    {
        // Handle standalone route where first param is actually the topic
        if ($roadmap instanceof Topic) {
            $topic = $roadmap;
            $roadmap = $topic->roadmap;
        }

        Gate::authorize('delete', $topic);
        $this->topicService->deleteTopic($topic);

        return redirect()
            ->route('roadmaps.show', $roadmap)
            ->with('success', 'Topic deleted successfully!');
    }
}
