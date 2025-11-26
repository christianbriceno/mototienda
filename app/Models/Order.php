<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Order extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'client_id',
        'payment_method',
        'exchange_rate',
        'total_price_usd',
        'total_price_bs',
        'total_price_usd_without_iva',
        'total_price_bs_without_iva',
        'total_cost_usd',
        'total_cost_bs',
        'amount_iva',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    // protected $with = ['orderPresentations'];

    /**
     * Get the invoice associated with the user.
     */
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

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
     * Get the paymentMethod that owns the order.
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method', 'name');
    }

    /**
     * The presentations that belong to the order.
     *
     * @return HasMany
     */
    public function orderPresentations(): HasMany
    {
        return $this->hasMany(OrderPresentation::class);
    }

    /**
     * The presentations that belong to the order.
     */
    public function presentations(): BelongsToMany
    {
        return $this->belongsToMany(Presentation::class)
            ->withPivot(
                'item_line',
                'quantity',
                'unit_price',
                'unit_cost',
                'sub_total_unit_price',
                'sub_total_unit_cost'
            )->withTimestamps();
    }

    /**
     * Undocumented function
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
}
