<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $filters = $request->input('filters', []);
        $user = $request->user();

        $results = [
            'roadmaps' => $this->searchRoadmaps($user, $query, $filters),
            'topics' => $this->searchTopics($user, $query, $filters),
            'resources' => $this->searchResources($user, $query, $filters),
        ];

        if ($request->expectsJson()) {
            return response()->json($results);
        }

        return view('search.results', compact('results', 'query'));
    }

    private function searchRoadmaps($user, $query, $filters)
    {
        $builder = $user->roadmaps();

        if ($query) {
            $builder->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            });
        }

        if (!empty($filters['status'])) {
            $builder->where('status', $filters['status']);
        }

        return $builder->with('topics')->take(10)->get();
    }

    private function searchTopics($user, $query, $filters)
    {
        $builder = $user->topics();

        if ($query) {
            $builder->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            });
        }

        if (!empty($filters['status'])) {
            $builder->where('status', $filters['status']);
        }

        return $builder->with('roadmap')->take(10)->get();
    }

    private function searchResources($user, $query, $filters)
    {
        $builder = $user->resources();

        if ($query) {
            $builder->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('url', 'like', "%{$query}%");
            });
        }

        if (!empty($filters['type'])) {
            $builder->where('type', $filters['type']);
        }

        return $builder->with('topic')->take(10)->get();
    }
}
