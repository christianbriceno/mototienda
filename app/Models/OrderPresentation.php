<?php

namespace App\Models;

use App\Observers\OrderPresentationObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderPresentation extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_presentation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'presentation_id',
        'item_line',
        'quantity',
        'unit_price',
        'unit_price_without_iva',
        'unit_cost',
        'sub_total_unit_price',
        'sub_total_unit_price_without_iva',
        'sub_total_unit_cost',
    ];

    /**
     * Undocumented function
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo
     */
    public function presentation(): BelongsTo
    {
        return $this->belongsTo(Presentation::class);
    }
}
