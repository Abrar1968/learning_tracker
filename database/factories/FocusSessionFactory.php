<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FocusSession>
 */
class FocusSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startedAt = fake()->dateTimeBetween('-7 days', 'now');
        $duration = fake()->numberBetween(15, 120);

        return [
            'user_id' => User::factory(),
            'topic_id' => null,
            'resource_id' => null,
            'started_at' => $startedAt,
            'ended_at' => (clone $startedAt)->modify("+{$duration} minutes"),
            'planned_duration' => $duration,
            'actual_duration' => $duration,
            'status' => 'completed',
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'ended_at' => null,
            'actual_duration' => null,
            'status' => 'active',
        ]);
    }

    public function paused(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paused',
        ]);
    }
}
