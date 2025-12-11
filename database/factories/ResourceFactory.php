<?php

namespace Database\Factories;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resource>
 */
class ResourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['video', 'article', 'book', 'course', 'documentation', 'other'];
        $type = fake()->randomElement($types);

        return [
            'topic_id' => Topic::factory(),
            'user_id' => User::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(2),
            'type' => $type,
            'url' => in_array($type, ['video', 'article', 'course', 'documentation']) ? fake()->url() : null,
            'file_path' => null,
            'file_size' => null,
            'estimated_duration' => fake()->numberBetween(10, 240),
            'is_completed' => fake()->boolean(30),
            'completed_at' => fake()->boolean(30) ? fake()->dateTimeBetween('-2 months', 'now') : null,
        ];
    }

    public function link(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'article',
            'url' => fake()->url(),
            'file_path' => null,
        ]);
    }

    public function video(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'video',
            'url' => 'https://youtube.com/watch?v=' . fake()->bothify('??########'),
            'file_path' => null,
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_completed' => true,
            'completed_at' => fake()->dateTimeBetween('-2 months', 'now'),
        ]);
    }
}
