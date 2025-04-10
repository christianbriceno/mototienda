<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'client_id',
        'order_id',

        'issuer_rif',
        'issuer_name',
        'issuer_address',
        'issuer_phone_number',
        'issuer_email',

        'receiver_rif',
        'receiver_identification_card',
        'receiver_name',
        'receiver_address',
        'receiver_phone_number',
        'receiver_email',

        'amount_iva',
        'total_with_iva',
        'total_without_iva',
    ];

    /**
     * Get the store that owns the order.
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    /**
     * Get the buyer that owns the order.
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Get the order that owns the order.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
