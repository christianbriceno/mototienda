<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderPresentation;
use App\Models\Presentation;

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

        $totalPriceUsd = $order->orderPresentations->sum('sub_total_unit_price');
        $totalPriceBs  = $totalPriceUsd * $order->exchange_rate;
        $totalCostUsd  = $order->orderPresentations->sum('sub_total_unit_cost');
        $totalCostBs   = $totalCostUsd * $order->exchange_rate;
        $totalPriceUsdWithoutIva = $order->orderPresentations->sum('sub_total_unit_price_without_iva');
        $totalPriceBsWithoutIva = $totalPriceUsdWithoutIva * $order->exchange_rate;
        $amountIva = $totalPriceUsd - $totalPriceUsdWithoutIva;

        $order->total_price_usd = $totalPriceUsd;
        $order->total_price_bs  = $totalPriceBs;
        $order->total_cost_usd  = $totalCostUsd;
        $order->total_cost_bs   = $totalCostBs;
        $order->total_price_usd_without_iva = $totalPriceUsdWithoutIva;
        $order->total_price_bs_without_iva  = $totalPriceBsWithoutIva;
        $order->amount_iva = $amountIva;

        $order->saveQuietly();

        $this->updatingInvoiceTotals($order);
    }

    /**
     * calculate costs the invoice
     *
     * @param Order $order
     * @return void
     */
    public function updatingInvoiceTotals(Order $order): void
    {
        $invoice = Invoice::where('order_id', $order->id)->first();

        $invoice->amount_iva        = $order->amount_iva ?? 0;
        $invoice->total_with_iva    = $order->total_price_usd ?? 0;
        $invoice->total_without_iva = $order->total_price_usd_without_iva ?? 0;

        $invoice->saveQuietly();
    }
}
