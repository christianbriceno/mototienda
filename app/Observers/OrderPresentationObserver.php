<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderPresentation;
use App\Models\Presentation;
use App\Models\Statu;

class OrderPresentationObserver
{
    /**
     * Handle the OrderPresentation "created" event.
     */
    public function created(OrderPresentation $orderPresentation): void
    {
        $this->calculateOrderTotals($orderPresentation);
    }

    /**
     * Handle the OrderPresentation "creating" event.
     */
    public function creating(OrderPresentation $orderPresentation): void
    {
        $this->addPresentation($orderPresentation, 'creating');
    }

    /**
     * Handle the OrderPresentation "updated" event.
     */
    public function updated(OrderPresentation $orderPresentation): void
    {
        //
    }

    /**
     * Handle the OrderPresentation "updating" event.
     */
    public function updating(OrderPresentation $orderPresentation): void
    {
        $this->addPresentation($orderPresentation, 'updating');
    }

    /**
     * Handle the OrderPresentation "deleted" event.
     */
    public function deleted(OrderPresentation $orderPresentation): void
    {
        //
    }

    /**
     * Handle the OrderPresentation "restored" event.
     */
    public function restored(OrderPresentation $orderPresentation): void
    {
        //
    }

    /**
     * Handle the OrderPresentation "force deleted" event.
     */
    public function forceDeleted(OrderPresentation $orderPresentation): void
    {
        //
    }

    /**
     * calculate costs the presentations
     *
     * @param OrderPresentation $orderPresentation
     * @return void
     */
    public function addPresentation(OrderPresentation $orderPresentation, String $accion): void
    {
        $presentation = Presentation::where('id', $orderPresentation->presentation_id)->first();

        $orderPresentation->unit_price = $presentation->price;
        $orderPresentation->unit_cost = $presentation->cost;
        $orderPresentation->sub_total_unit_price = $orderPresentation->quantity * $presentation->price;
        $orderPresentation->sub_total_unit_cost = $orderPresentation->quantity * $presentation->cost;
        $orderPresentation->unit_price_without_iva = round($presentation->price / (1.16), 2);
        $orderPresentation->sub_total_unit_price_without_iva = $orderPresentation->quantity * $orderPresentation->unit_price_without_iva;
        $accion == 'updating' ? $orderPresentation->saveQuietly() : null;
    }

    /**
     * calculate costs the order
     *
     * @param OrderPresentation $orderPresentation
     * @return void
     */
    public function calculateOrderTotals(OrderPresentation $orderPresentation): void
    {
        $order = Order::where('id', $orderPresentation->order->id)->first();

        $totalPriceUsd           = round($order->orderPresentations->sum('sub_total_unit_price'), 2);
        $totalPriceBs            = round($totalPriceUsd * $order->exchange_rate, 2);
        $totalCostUsd            = round($order->orderPresentations->sum('sub_total_unit_cost'), 2);
        $totalCostBs             = round($totalCostUsd * $order->exchange_rate, 2);
        $totalPriceUsdWithoutIva = round($order->orderPresentations->sum('sub_total_unit_price_without_iva'), 2);
        $totalPriceBsWithoutIva  = round($totalPriceUsdWithoutIva * $order->exchange_rate, 2);
        $amountIva               = round($totalPriceUsd - $totalPriceUsdWithoutIva, 2);

        $order->total_price_usd  = $totalPriceUsd;
        $order->total_price_bs   = $totalPriceBs;
        $order->total_cost_usd   = $totalCostUsd;
        $order->total_cost_bs    = $totalCostBs;
        $order->total_price_usd_without_iva = $totalPriceUsdWithoutIva;
        $order->total_price_bs_without_iva  = $totalPriceBsWithoutIva;
        $order->amount_iva = $amountIva;

        $order->saveQuietly();
    }
}
