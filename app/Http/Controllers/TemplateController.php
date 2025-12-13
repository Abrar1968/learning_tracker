<?php

namespace App\Http\Controllers;

use App\Models\RoadmapTemplate;
use App\Services\TemplateService;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function __construct(
        protected TemplateService $templateService
    ) {}

    /**
     * Display template gallery
     */
    public function index(Request $request)
    {
        $query = $request->query('q');
        $category = $request->query('category');
        $difficulty = $request->query('difficulty');

        if ($query || $category || $difficulty) {
            $templates = $this->templateService->search($query, $category, $difficulty);
        } else {
            $templates = RoadmapTemplate::where('is_active', true)
                ->orderByDesc('is_featured')
                ->orderByDesc('rating')
                ->paginate(12);
        }

        $featured = $this->templateService->getFeaturedTemplates();
        $categories = $this->templateService->getCategoriesWithCounts();

        return view('templates.index', compact('templates', 'featured', 'categories', 'query', 'category', 'difficulty'));
    }

    /**
     * Show template details
     */
    public function show(RoadmapTemplate $template)
    {
        $template->load('creator');
        $relatedTemplates = RoadmapTemplate::where('is_active', true)
            ->where('id', '!=', $template->id)
            ->where('category', $template->category)
            ->limit(4)
            ->get();

        return view('templates.show', compact('template', 'relatedTemplates'));
    }

    /**
     * Clone a template to create a new roadmap
     */
    public function clone(RoadmapTemplate $template)
    {
        $roadmap = $this->templateService->cloneForUser($template, auth()->user());

        return redirect()
            ->route('roadmaps.show', $roadmap)
            ->with('success', "Roadmap created from template '{$template->name}'!");
    }

    /**
     * Create template from existing roadmap
     */
    public function createFromRoadmap(Request $request, \App\Models\Roadmap $roadmap)
    {
        if ($roadmap->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'sometimes|string|max:1000',
            'category' => 'required|in:' . implode(',', array_keys(RoadmapTemplate::CATEGORIES)),
            'difficulty' => 'required|in:' . implode(',', array_keys(RoadmapTemplate::DIFFICULTIES)),
        ]);

        $template = $this->templateService->createFromRoadmap(
            $roadmap,
            $validated['name'],
            $validated['description'] ?? null,
            $validated['category'],
            $validated['difficulty']
        );

        return redirect()
            ->route('templates.show', $template)
            ->with('success', 'Template created successfully!');
    }

    /**
     * Rate a template
     */
    public function rate(Request $request, RoadmapTemplate $template)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $this->templateService->rateTemplate($template, $validated['rating']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'new_rating' => $template->fresh()->rating,
            ]);
        }

        return redirect()->back()->with('success', 'Thank you for your rating!');
    }
}
