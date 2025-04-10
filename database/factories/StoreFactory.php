<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'      => $this->faker->name(),
            'rif'       => $this->faker->numberBetween(0, 100000000),
            'address'   => $this->faker->address(),
            'email'     => $this->faker->email(),
            'whatsapp'  => $this->faker->phoneNumber(),
            'facebook'  => $this->faker->url(),
            'instagram' => $this->faker->url(),
            'logo'      => $this->faker->imageUrl(950, 400),
        ];
    }
}
