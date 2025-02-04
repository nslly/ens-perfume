<?php

namespace App\Models\Order;

use App\Models\User;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'payment_method',
    ];


    protected $casts = [
        'status' => OrderStatus::class,
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
