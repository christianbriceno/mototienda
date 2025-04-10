<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderPresentation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $order = Order::factory()->create();

        $orderPresentations = OrderPresentation::factory(2)->create([
            'order_id' => $order,
        ]);

        $totalPriceUsd = $orderPresentations->sum('sub_total_unit_price');
        $totalPriceWithoutIva = $orderPresentations->sum('sub_total_unit_price_without_iva');
        $totalCostUsd = $orderPresentations->sum('sub_total_unit_cost');

        $order->update([
            'total_price_usd' => $totalPriceUsd,
            'total_price_bs'  => $totalPriceUsd * $order->exchange_rate,
            'total_price_usd_without_iva' => $totalPriceWithoutIva,
            'total_price_bs_without_iva'  => $totalPriceWithoutIva * $order->exchange_rate,
            'total_cost_usd'  => $totalCostUsd,
            'total_cost_bs'   => $totalCostUsd * $order->exchange_rate,
            'amount_iva' => $totalPriceUsd - ($totalPriceUsd / (1.16))
        ]);

        // $invoice = Invoice::factory()->create([
        //     'order_id' => $order->id,
        // ]);
    }
}
