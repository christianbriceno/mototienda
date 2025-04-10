<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Delivery;
use App\Models\ExchangeRate;
use App\Models\Reservation;
use App\Models\Statu;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $total_price_usd = $this->faker->numberBetween(55, 100);
        // $total_price_bs  = $this->faker->numberBetween(30, 50);

        return [
            'client_id'            => Client::inRandomOrder()->first(),
            'exchange_rate'        => ExchangeRate::inRandomOrder()->first()->exchange_rate,
            'amount_iva'           => 0,
            'payment_method'       => 'cash',
            // 'total_price_usd'      => $total_price_usd,
            // 'total_price_bs'       => $total_price_bs,
            // 'total_cost_usd'       => $total_price_usd - ($total_price_usd * (30 / 100)),
            // 'total_cost_bs'        => $total_price_bs - ($total_price_usd * (30 / 100)),
        ];
    }
}
