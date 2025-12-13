<?php

namespace Database\Factories;

use App\Models\Roadmap;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActivityLog>
 */
class ActivityLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['roadmap_created', 'topic_completed', 'resource_added', 'focus_session', 'review_completed', 'challenge_completed'];

        return [
            'user_id' => User::factory(),
            'type' => fake()->randomElement($types),
            'description' => fake()->sentence(),
            'subject_type' => 'App\\Models\\Roadmap',
            'subject_id' => Roadmap::factory(),
            'properties' => json_encode(['key' => 'value']),
            'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }

    public function forRoadmap(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'roadmap_created',
            'subject_type' => 'App\\Models\\Roadmap',
            'subject_id' => Roadmap::factory(),
        ]);
    }

    public function forTopic(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'topic_completed',
            'subject_type' => 'App\\Models\\Topic',
            'subject_id' => Topic::factory(),
        ]);
    }
}
