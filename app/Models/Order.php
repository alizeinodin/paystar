<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'status',
        'ref_num',
        'transaction_id',
        'tracking_code',
    ];

    protected $casts = [
        'status' => OrderStatus::class
    ];

    public function creditCard(): BelongsTo
    {
        return $this->belongsTo(CreditCard::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class,
            'orders_products', 'order_id', 'product_id');
    }
}
