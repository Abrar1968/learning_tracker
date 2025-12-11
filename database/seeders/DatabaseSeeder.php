<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Roadmap;
use App\Models\Topic;
use App\Models\Resource;
use App\Models\ResourceTag;
use App\Models\TopicProgress;
use App\Models\ActivityLog;
use App\Models\Certificate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Creating test user...');

        // Create test user
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->command->info('Creating roadmaps...');

        // Create 3 roadmaps with different statuses
        $completedRoadmap = Roadmap::factory()->completed()->create([
            'user_id' => $user->id,
            'title' => 'Laravel Full Stack Development',
            'description' => 'Master Laravel framework from basics to advanced topics',
        ]);

        $inProgressRoadmap = Roadmap::factory()->inProgress()->create([
            'user_id' => $user->id,
            'title' => 'React & Next.js Mastery',
            'description' => 'Learn modern React with Next.js framework',
        ]);

        $notStartedRoadmap = Roadmap::factory()->notStarted()->create([
            'user_id' => $user->id,
            'title' => 'DevOps & Cloud Infrastructure',
            'description' => 'Master Docker, Kubernetes, and AWS',
        ]);

        $this->command->info('Creating topics for completed roadmap...');

        // Completed Roadmap Topics
        $laravelBasics = Topic::factory()->completed()->create([
            'roadmap_id' => $completedRoadmap->id,
            'title' => 'Laravel Basics',
            'description' => 'Understanding Laravel fundamentals',
            'order' => 1,
            'estimated_hours' => 20,
            'actual_hours' => 22,
            'weightage' => 8,
        ]);

        $laravelAdvanced = Topic::factory()->completed()->create([
            'roadmap_id' => $completedRoadmap->id,
            'title' => 'Advanced Laravel',
            'description' => 'Advanced concepts and patterns',
            'order' => 2,
            'estimated_hours' => 30,
            'actual_hours' => 35,
            'weightage' => 10,
        ]);

        // Subtopics for Laravel Basics
        $routing = Topic::factory()->completed()->create([
            'roadmap_id' => $completedRoadmap->id,
            'parent_id' => $laravelBasics->id,
            'title' => 'Routing & Controllers',
            'order' => 1,
            'estimated_hours' => 5,
            'actual_hours' => 6,
            'weightage' => 7,
        ]);

        $eloquent = Topic::factory()->completed()->create([
            'roadmap_id' => $completedRoadmap->id,
            'parent_id' => $laravelBasics->id,
            'title' => 'Eloquent ORM',
            'order' => 2,
            'estimated_hours' => 8,
            'actual_hours' => 9,
            'weightage' => 9,
        ]);

        $this->command->info('Creating topics for in-progress roadmap...');

        // In Progress Roadmap Topics
        $reactBasics = Topic::factory()->create([
            'roadmap_id' => $inProgressRoadmap->id,
            'title' => 'React Fundamentals',
            'status' => 'completed',
            'order' => 1,
            'estimated_hours' => 25,
            'actual_hours' => 28,
            'weightage' => 9,
        ]);

        $nextjsBasics = Topic::factory()->create([
            'roadmap_id' => $inProgressRoadmap->id,
            'title' => 'Next.js Basics',
            'status' => 'in_progress',
            'order' => 2,
            'estimated_hours' => 20,
            'actual_hours' => 10,
            'weightage' => 8,
        ]);

        $advancedNextjs = Topic::factory()->create([
            'roadmap_id' => $inProgressRoadmap->id,
            'title' => 'Advanced Next.js',
            'status' => 'not_started',
            'order' => 3,
            'estimated_hours' => 30,
            'weightage' => 10,
        ]);

        $this->command->info('Creating topics for not-started roadmap...');

        // Not Started Roadmap Topics
        $dockerBasics = Topic::factory()->create([
            'roadmap_id' => $notStartedRoadmap->id,
            'title' => 'Docker Fundamentals',
            'status' => 'not_started',
            'order' => 1,
            'estimated_hours' => 15,
            'weightage' => 7,
        ]);

        $kubernetes = Topic::factory()->create([
            'roadmap_id' => $notStartedRoadmap->id,
            'title' => 'Kubernetes Essentials',
            'status' => 'not_started',
            'order' => 2,
            'estimated_hours' => 25,
            'weightage' => 9,
        ]);

        $this->command->info('Creating resources...');

        // Resources for topics
        $routingResource1 = Resource::factory()->completed()->create([
            'topic_id' => $routing->id,
            'user_id' => $user->id,
            'title' => 'Laravel Routing Documentation',
            'type' => 'documentation',
            'url' => 'https://laravel.com/docs/routing',
        ]);

        $routingResource2 = Resource::factory()->video()->completed()->create([
            'topic_id' => $routing->id,
            'user_id' => $user->id,
            'title' => 'Laravel Routing Tutorial',
        ]);

        $eloquentResource1 = Resource::factory()->completed()->create([
            'topic_id' => $eloquent->id,
            'user_id' => $user->id,
            'title' => 'Eloquent ORM Guide',
            'type' => 'article',
            'url' => 'https://laravel.com/docs/eloquent',
        ]);

        $reactResource = Resource::factory()->completed()->create([
            'topic_id' => $reactBasics->id,
            'user_id' => $user->id,
            'title' => 'React Official Documentation',
            'type' => 'documentation',
            'url' => 'https://react.dev',
        ]);

        $nextjsResource = Resource::factory()->create([
            'topic_id' => $nextjsBasics->id,
            'user_id' => $user->id,
            'title' => 'Next.js Tutorial',
            'type' => 'course',
            'url' => 'https://nextjs.org/learn',
            'is_completed' => false,
        ]);

        $this->command->info('Creating resource tags...');

        // Resource Tags
        ResourceTag::create(['resource_id' => $routingResource1->id, 'tag_name' => 'routing']);
        ResourceTag::create(['resource_id' => $routingResource1->id, 'tag_name' => 'laravel']);
        ResourceTag::create(['resource_id' => $routingResource1->id, 'tag_name' => 'official']);
        ResourceTag::create(['resource_id' => $routingResource2->id, 'tag_name' => 'video']);
        ResourceTag::create(['resource_id' => $routingResource2->id, 'tag_name' => 'tutorial']);
        ResourceTag::create(['resource_id' => $eloquentResource1->id, 'tag_name' => 'eloquent']);
        ResourceTag::create(['resource_id' => $eloquentResource1->id, 'tag_name' => 'database']);
        ResourceTag::create(['resource_id' => $reactResource->id, 'tag_name' => 'react']);
        ResourceTag::create(['resource_id' => $reactResource->id, 'tag_name' => 'frontend']);
        ResourceTag::create(['resource_id' => $nextjsResource->id, 'tag_name' => 'nextjs']);
        ResourceTag::create(['resource_id' => $nextjsResource->id, 'tag_name' => 'framework']);

        $this->command->info('Creating topic progress...');

        // Topic Progress
        TopicProgress::factory()->completed()->create([
            'topic_id' => $laravelBasics->id,
            'user_id' => $user->id,
            'started_at' => now()->subMonths(3),
            'completed_at' => now()->subMonths(2),
            'time_spent' => 1320,
            'resources_completed' => 5,
            'total_resources' => 5,
            'notes' => 'Completed all basics. Ready for advanced topics.',
        ]);

        TopicProgress::factory()->completed()->create([
            'topic_id' => $laravelAdvanced->id,
            'user_id' => $user->id,
            'started_at' => now()->subMonths(2),
            'completed_at' => now()->subMonth(),
            'time_spent' => 2100,
            'resources_completed' => 8,
            'total_resources' => 8,
        ]);

        TopicProgress::factory()->completed()->create([
            'topic_id' => $routing->id,
            'user_id' => $user->id,
            'started_at' => now()->subMonths(3),
            'completed_at' => now()->subMonths(3)->addWeek(),
            'time_spent' => 360,
            'resources_completed' => 2,
            'total_resources' => 2,
        ]);

        TopicProgress::factory()->completed()->create([
            'topic_id' => $eloquent->id,
            'user_id' => $user->id,
            'started_at' => now()->subMonths(3)->addWeek(),
            'completed_at' => now()->subMonths(2)->addDays(3),
            'time_spent' => 540,
            'resources_completed' => 1,
            'total_resources' => 1,
        ]);

        TopicProgress::factory()->completed()->create([
            'topic_id' => $reactBasics->id,
            'user_id' => $user->id,
            'started_at' => now()->subMonths(2),
            'completed_at' => now()->subMonth(),
            'time_spent' => 1680,
            'resources_completed' => 1,
            'total_resources' => 1,
        ]);

        TopicProgress::factory()->create([
            'topic_id' => $nextjsBasics->id,
            'user_id' => $user->id,
            'started_at' => now()->subMonth(),
            'completed_at' => null,
            'time_spent' => 600,
            'resources_completed' => 0,
            'total_resources' => 1,
            'notes' => 'Making good progress. Halfway through the course.',
        ]);

        $this->command->info('Creating certificate...');

        // Certificate for completed roadmap
        Certificate::factory()->create([
            'roadmap_id' => $completedRoadmap->id,
            'user_id' => $user->id,
            'issue_date' => now()->subMonth(),
            'total_hours' => 132,
            'completion_percentage' => 100,
        ]);

        $this->command->info('Creating activity logs...');

        // Activity Logs
        ActivityLog::create([
            'user_id' => $user->id,
            'loggable_type' => Roadmap::class,
            'loggable_id' => $completedRoadmap->id,
            'action' => 'created',
            'description' => 'Created roadmap: Laravel Full Stack Development',
            'metadata' => ['status' => 'not_started'],
            'created_at' => now()->subMonths(4),
        ]);

        ActivityLog::create([
            'user_id' => $user->id,
            'loggable_type' => Roadmap::class,
            'loggable_id' => $completedRoadmap->id,
            'action' => 'completed',
            'description' => 'Completed roadmap: Laravel Full Stack Development',
            'metadata' => ['total_hours' => 132],
            'created_at' => now()->subMonth(),
        ]);

        ActivityLog::create([
            'user_id' => $user->id,
            'loggable_type' => Topic::class,
            'loggable_id' => $laravelBasics->id,
            'action' => 'completed',
            'description' => 'Completed topic: Laravel Basics',
            'created_at' => now()->subMonths(2),
        ]);

        ActivityLog::create([
            'user_id' => $user->id,
            'loggable_type' => Roadmap::class,
            'loggable_id' => $inProgressRoadmap->id,
            'action' => 'started',
            'description' => 'Started roadmap: React & Next.js Mastery',
            'created_at' => now()->subMonths(2),
        ]);

        ActivityLog::create([
            'user_id' => $user->id,
            'loggable_type' => Topic::class,
            'loggable_id' => $nextjsBasics->id,
            'action' => 'started',
            'description' => 'Started topic: Next.js Basics',
            'created_at' => now()->subMonth(),
        ]);

        // Update roadmap progress
        $completedRoadmap->updateProgress();
        $inProgressRoadmap->updateProgress();
        $notStartedRoadmap->updateProgress();

        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->newLine();
        $this->command->info('Test User Credentials:');
        $this->command->info('Email: test@example.com');
        $this->command->info('Password: password');
        $this->command->newLine();
        $this->command->info('Data Created:');
        $this->command->info('- 3 Roadmaps (1 completed, 1 in progress, 1 not started)');
        $this->command->info('- 9 Topics (with subtopics)');
        $this->command->info('- 5 Resources');
        $this->command->info('- 11 Resource Tags');
        $this->command->info('- 6 Topic Progress records');
        $this->command->info('- 1 Certificate');
        $this->command->info('- 5 Activity Logs');
    }
}
