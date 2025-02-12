<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];
}
