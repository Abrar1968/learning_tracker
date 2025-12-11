<?php

namespace Database\Factories;

use App\Models\Roadmap;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Topic>
 */
class TopicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['not_started', 'in_progress', 'completed'];

        return [
            'roadmap_id' => Roadmap::factory(),
            'parent_id' => null,
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(2),
            'status' => fake()->randomElement($statuses),
            'order' => 0,
            'estimated_hours' => fake()->numberBetween(2, 40),
            'actual_hours' => 0,
            'weightage' => fake()->numberBetween(1, 10),
        ];
    }

    public function subtopic(): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => Topic::factory(),
            'weightage' => fake()->numberBetween(1, 5),
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'actual_hours' => fake()->numberBetween(2, $attributes['estimated_hours'] ?? 20),
        ]);
    }
}
