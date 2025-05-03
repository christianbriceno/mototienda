<?php

namespace Database\Factories;

use App\Models\Sex;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'                => $this->faker->name(),
            'last_name'           => $this->faker->lastName(),
            'identification_card' => $this->faker->numberBetween(0, 100000000),
            'sex_id'              => Sex::inRandomOrder()->first(),
            'address'             => $this->faker->address(),
            'email'               => fake()->unique()->safeEmail(),
            'phone'               => $this->faker->phoneNumber(),
        ];
    }
}
