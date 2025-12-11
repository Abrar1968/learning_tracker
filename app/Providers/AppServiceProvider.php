<?php

namespace App\Providers;

use App\Models\Roadmap;
use App\Models\Topic;
use App\Models\Resource;
use App\Policies\RoadmapPolicy;
use App\Policies\TopicPolicy;
use App\Policies\ResourcePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Roadmap::class, RoadmapPolicy::class);
        Gate::policy(Topic::class, TopicPolicy::class);
        Gate::policy(Resource::class, ResourcePolicy::class);
    }
}
