<?php

namespace Database\Factories;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TopicProgress>
 */
class TopicProgressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $started = fake()->dateTimeBetween('-3 months', 'now');
        $isCompleted = fake()->boolean(40);

        return [
            'topic_id' => Topic::factory(),
            'user_id' => User::factory(),
            'started_at' => $started,
            'completed_at' => $isCompleted ? fake()->dateTimeBetween($started, 'now') : null,
            'time_spent' => fake()->numberBetween(30, 600),
            'notes' => fake()->boolean(60) ? fake()->paragraph(2) : null,
            'resources_completed' => 0,
            'total_resources' => 0,
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'completed_at' => fake()->dateTimeBetween($attributes['started_at'] ?? '-1 month', 'now'),
            'time_spent' => fake()->numberBetween(120, 1200),
        ]);
    }
}
