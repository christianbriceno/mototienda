<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
     * Get the buyer that owns the order.
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Undocumented function
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
}
