<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CartItem;
use App\Models\OrderItem;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'stock_quantity'
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
