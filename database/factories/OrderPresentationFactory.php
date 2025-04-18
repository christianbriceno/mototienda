<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Presentation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderPresentation>
 */
class OrderPresentationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $presentation = Presentation::inRandomOrder() ? Presentation::inRandomOrder()->first() : null;
        $order = Order::inRandomOrder()->first();
        $quantity = $this->faker->numberBetween(2, 5);

        return [
            'order_id'               => $order->id,
            'presentation_id'        => $presentation->id,
            'item_line'              => null,
            'quantity'               => $quantity,
            'auxiliary_quantity'     => $quantity,
            'unit_price'             => $presentation->price,
            'unit_price_without_iva' => round($presentation->price / 1.16, 2),
            'sub_total_unit_price'   => $presentation->price * $quantity,
            'sub_total_unit_price_without_iva' => $quantity * round($presentation->price / 1.16, 2),
            'unit_cost'              => $presentation->cost,
            'sub_total_unit_cost'    => $presentation->cost * $quantity,
        ];
    }
}
