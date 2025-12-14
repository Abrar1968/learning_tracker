<?php

namespace Database\Factories;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReviewSchedule>
 */
class ReviewScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $intervals = [1, 3, 7, 14, 30, 60, 90];

        return [
            'user_id' => User::factory(),
            'topic_id' => Topic::factory(),
            'resource_id' => null,
            'next_review_date' => fake()->dateTimeBetween('now', '+30 days'),
            'last_review_date' => fake()->optional()->dateTimeBetween('-30 days', 'now'),
            'repetition_count' => fake()->numberBetween(0, 10),
            'interval_days' => fake()->randomElement($intervals),
            'easiness_factor' => fake()->randomFloat(2, 1.3, 2.5),
            'quality_score' => fake()->optional()->numberBetween(0, 5),
            'is_active' => true,
        ];
    }

    public function suspended(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function dueToday(): static
    {
        return $this->state(fn (array $attributes) => [
            'next_review_date' => now(),
            'is_active' => true,
        ]);
    }

    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'next_review_date' => now()->subDays(3),
            'is_active' => true,
        ]);
    }
}
