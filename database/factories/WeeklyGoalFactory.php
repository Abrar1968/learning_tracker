<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WeeklyGoal>
 */
class WeeklyGoalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $targetHours = fake()->numberBetween(5, 20);

        return [
            'user_id' => User::factory(),
            'week_start' => now()->startOfWeek()->toDateString(),
            'week_end' => now()->endOfWeek()->toDateString(),
            'target_focus_hours' => $targetHours,
            'actual_focus_hours' => fake()->numberBetween(0, $targetHours),
            'target_topics' => fake()->numberBetween(3, 10),
            'completed_topics' => 0,
            'is_achieved' => false,
        ];
    }

    public function achieved(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'actual_focus_hours' => $attributes['target_focus_hours'] + 1,
                'completed_topics' => $attributes['target_topics'],
                'is_achieved' => true,
            ];
        });
    }
}
