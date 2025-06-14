<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => $this->faker->unique()->company,
            'license_no' => strtoupper(Str::random(3)) . '-' . $this->faker->unique()->numerify('#####'),
            'license_expiry' => $this->faker->dateTimeBetween('now', '+3 years')->format('Y-m-d'),
            'address' => $this->faker->optional()->address,
            'status' => $this->faker->randomElement(['active', 'expired', 'suspended']),

        ];
    }
}
