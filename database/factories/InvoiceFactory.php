<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Order;
use App\Models\Store;
use App\Models\Statu;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $store      = Store::inRandomOrder()->first();
        $order      = Order::inRandomOrder()->first();
        $buyer      = $order->buyer;

        $amountIva       = $order->amount_iva;
        $totalWithIva    = $order->total_price_usd;
        $totalWithoutIva = $order->total_price_usd_without_iva;

        return [
            'store_id'                     => $store->id,
            'client_id'                    => $buyer->id,
            'order_id'                     => $order->id,

            'issuer_rif'                   => $store->rif,
            'issuer_name'                  => $store->name,
            'issuer_address'               => $store->address,
            'issuer_phone_number'          => $store->whatsapp,
            'issuer_email'                 => $store->email,

            'receiver_rif'                 => $buyer->rif ?? null,
            'receiver_identification_card' => $buyer->identification_card ?? null,
            'receiver_name'                => $buyer->name,
            'receiver_address'             => $buyer->address ?? null,
            'receiver_phone_number'        => $buyer->phone ?? null,
            'receiver_email'               => $buyer->email ?? null,

            'amount_iva'                   => $amountIva,
            'total_with_iva'               => $totalWithIva,
            'total_without_iva'            => $totalWithoutIva,
        ];
    }
}
