<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Roadmap>
 */
class RoadmapFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['not_started', 'in_progress', 'completed'];
        $status = fake()->randomElement($statuses);

        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(3),
            'status' => $status,
            'start_date' => $status !== 'not_started' ? fake()->dateTimeBetween('-6 months', 'now') : null,
            'target_end_date' => fake()->dateTimeBetween('now', '+1 year'),
            'actual_end_date' => $status === 'completed' ? fake()->dateTimeBetween('-3 months', 'now') : null,
            'progress_percentage' => match($status) {
                'not_started' => 0,
                'in_progress' => fake()->numberBetween(1, 99),
                'completed' => 100,
            },
            'total_topics' => 0,
            'completed_topics' => 0,
        ];
    }

    public function notStarted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'not_started',
            'start_date' => null,
            'actual_end_date' => null,
            'progress_percentage' => 0,
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'in_progress',
            'start_date' => fake()->dateTimeBetween('-6 months', 'now'),
            'progress_percentage' => fake()->numberBetween(1, 99),
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'start_date' => fake()->dateTimeBetween('-6 months', '-3 months'),
            'actual_end_date' => fake()->dateTimeBetween('-3 months', 'now'),
            'progress_percentage' => 100,
        ]);
    }
}
