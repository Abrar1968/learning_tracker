<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoadmapTemplate>
 */
class RoadmapTemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['programming', 'design', 'data-science', 'devops', 'business', 'language', 'other'];

        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(2),
            'category' => fake()->randomElement($categories),
            'estimated_hours' => fake()->numberBetween(20, 200),
            'difficulty_level' => fake()->randomElement(['beginner', 'intermediate', 'advanced']),
            'topics_count' => fake()->numberBetween(5, 20),
            'structure' => json_encode([
                ['title' => 'Introduction', 'description' => 'Getting started'],
                ['title' => 'Core Concepts', 'description' => 'Main content'],
                ['title' => 'Advanced Topics', 'description' => 'Deep dive'],
            ]),
            'is_public' => true,
            'clone_count' => fake()->numberBetween(0, 100),
            'rating' => fake()->optional()->randomFloat(1, 3, 5),
            'ratings_count' => fake()->numberBetween(0, 50),
        ];
    }

    public function private(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_public' => false,
        ]);
    }

    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'clone_count' => fake()->numberBetween(100, 1000),
            'rating' => fake()->randomFloat(1, 4, 5),
            'ratings_count' => fake()->numberBetween(50, 500),
        ]);
    }
}
