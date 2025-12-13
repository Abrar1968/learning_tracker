<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DailyChallenge>
 */
class DailyChallengeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['focus_time', 'complete_topic', 'add_resource', 'review_topic', 'complete_resource'];
        $type = fake()->randomElement($types);
        $targetValue = match($type) {
            'focus_time' => fake()->numberBetween(30, 120),
            default => fake()->numberBetween(1, 5),
        };

        return [
            'user_id' => User::factory(),
            'challenge_date' => now()->toDateString(),
            'type' => $type,
            'description' => fake()->sentence(),
            'target_value' => $targetValue,
            'current_value' => 0,
            'is_completed' => false,
            'xp_reward' => fake()->numberBetween(10, 50),
        ];
    }

    public function completed(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'current_value' => $attributes['target_value'],
                'is_completed' => true,
            ];
        });
    }

    public function forToday(): static
    {
        return $this->state(fn (array $attributes) => [
            'challenge_date' => now()->toDateString(),
        ]);
    }
}
