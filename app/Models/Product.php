<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'index_picture',
    ];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class,
            'orders_products', 'product_id', 'order_id');
    }
}
