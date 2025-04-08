<?php

namespace Database\Factories;

use App\Models\CategoryPresentation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Presentation>
 */
class PresentationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cost  = $this->faker->numberBetween(5, 40);
        $price = $cost + ($cost * (30 / 100));
        $stock = $this->faker->numberBetween(1, 10);

        return [
            'code'  => $this->faker->uuid(),
            'name'  => $this->faker->name(),
            'price' => $price,
            'cost'  => $cost,
            'stock' => $stock,
            'photo' => $this->faker->imageUrl(950, 400),
        ];
    }
}
