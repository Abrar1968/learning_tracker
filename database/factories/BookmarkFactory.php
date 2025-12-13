<?php

namespace Database\Factories;

use App\Models\Roadmap;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bookmark>
 */
class BookmarkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'bookmarkable_type' => 'App\\Models\\Roadmap',
            'bookmarkable_id' => Roadmap::factory(),
            'folder' => fake()->optional()->randomElement(['Learning', 'Important', 'Review', 'Favorites']),
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function forRoadmap(): static
    {
        return $this->state(fn (array $attributes) => [
            'bookmarkable_type' => 'App\\Models\\Roadmap',
            'bookmarkable_id' => Roadmap::factory(),
        ]);
    }

    public function forTopic(): static
    {
        return $this->state(fn (array $attributes) => [
            'bookmarkable_type' => 'App\\Models\\Topic',
            'bookmarkable_id' => Topic::factory(),
        ]);
    }
}
