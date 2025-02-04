<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    
    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'comment'
    ];
}
