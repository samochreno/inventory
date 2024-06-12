<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = Str::title(substr($this->faker->sentence(2, false), 0, -1));

        $isRegistered = $this->faker->boolean;
        $registrationNumber = $isRegistered
            ? $this->faker->randomNumber(6)
            : null;

        return [
            'name'                => $name,
            'registration_number' => $registrationNumber,
            'is_registered'       => $isRegistered,
        ];
    }
}
