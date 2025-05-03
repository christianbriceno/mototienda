<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Presentation;
use App\Models\Role;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        $this->creatingInvoice($order);

        $users = User::whereHas('roles', function (Builder $query) {
            auth()->user()
                ? $query->where('level', '<=', auth()->user()->roles->last()->level)
                : $query->where('level', '<=', Role::LEVEL_SELLER);
        })->get();

        Notification::make()
            ->title('Nuevo pedido #' . $order->id)
            ->success()
            ->body('Se registro exitosamente un nuevo pedido.')
            ->sendToDatabase($users);
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        $this->updatingInvoice($order);

        $users = User::whereHas('roles', function (Builder $query) {
            auth()->user()
                ? $query->where('level', '<=', auth()->user()->roles->last()->level)
                : $query->where('level', '<=', Role::LEVEL_SELLER);
        })->get();

        Notification::make()
            ->title('Estatus de pedido')
            ->success()
            ->body('El pedido #' . $order->id . ' cambió')
            ->sendToDatabase($users);
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleting(Order $order): void
    {
        //delete orderPresentations 
        $orderPresentations = $order->orderPresentations()->get();
        foreach ($orderPresentations as $orderPresentation) {
            $orderPresentation->deleted_at = now();
            $orderPresentation->saveQuietly();
        }

        //delete invoice
        $invoice = Invoice::where('id', $order->invoice->id)->first();
        $invoice->delete();
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        $users = User::whereHas('roles', function (Builder $query) {
            auth()->user()
                ? $query->where('level', '<=', auth()->user()->roles->last()->level)
                : $query->where('level', '<=', Role::LEVEL_SELLER);
        })->get();

        Notification::make()
            ->title('Pedido Eliminado')
            ->success()
            ->body('El pedido #' . $order->id . ' se elimino exitosamente')
            ->sendToDatabase($users);
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }

    /**
     * Undocumented function
     *
     * @param Order $order
     * @return void
     */
    public function creatingInvoice(Order $order)
    {
        $store = $order->store;
        $buyer = $order->buyer;

        Invoice::create([
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

            'amount_iva'                   => $order->amount_iva ?? 0,
            'total_with_iva'               => $order->total_price_usd ?? 0,
            'total_without_iva'            => $order->total_price_usd_without_iva ?? 0,
        ]);
    }

    /**
     * Undocumented function
     *
     * @param Order $order
     * @return void
     */
    public function updatingInvoice(Order $order)
    {
        $store = $order->store;
        $buyer = $order->buyer;
        $invoice = $order->invoice;

        $invoice->update([
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

            'amount_iva'                   => $order->amount_iva ?? 0,
            'total_with_iva'               => $order->total_price_usd ?? 0,
            'total_without_iva'            => $order->total_price_usd_without_iva ?? 0,
        ]);
    }
}
