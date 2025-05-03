<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Delivery;
use App\Models\ExchangeRate;
use App\Models\Reservation;
use App\Models\Statu;
use App\Models\Store;
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
        return [
            'store_id'             => Store::inRandomOrder()->first(),
            'client_id'            => Client::inRandomOrder()->first(),
            'exchange_rate'        => ExchangeRate::inRandomOrder()->first()->exchange_rate,
            'amount_iva'           => 0,
            'payment_method'       => 'cash',
        ];
    }
}
