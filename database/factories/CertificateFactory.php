<?php

namespace Database\Factories;

use App\Models\Roadmap;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Certificate>
 */
class CertificateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'roadmap_id' => Roadmap::factory(),
            'user_id' => User::factory(),
            'certificate_number' => 'CERT-' . date('Y') . '-' . strtoupper(Str::random(8)),
            'verification_code' => strtoupper(Str::random(16)),
            'issue_date' => fake()->dateTimeBetween('-6 months', 'now'),
            'file_path' => null,
            'total_hours' => fake()->numberBetween(20, 500),
            'completion_percentage' => 100,
        ];
    }
}
