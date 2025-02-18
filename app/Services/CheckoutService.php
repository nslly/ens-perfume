<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order\Order;
use App\Models\Product\Cart;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    /**
     * Checkout the cart products
     * 
     * @param array $formData validated data
     * @return Order
     */
    public function store(array $formData): Order
    {
        return DB::transaction(function () use ($formData) {


            $order = Order::query()->create([
                'user_id' => auth()->id(),
                'total_amount' => $formData['total_amount'],
                'status' => OrderStatus::Pending,
                'payment_method' => $formData['payment_method'],
            ]);

            $carts = Cart::query()->with(['user'])->where('user_id', auth()->id())->get();

            foreach ($carts as $cart) {
                $order->orderItems()->create([
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->price,
                ]);

                $cart->product()->update([
                    'quantity' => $cart->product->quantity - $cart->quantity,
                ]);
            }

            Cart::query()->where('user_id', auth()->id())->delete();
            return $order;
        });
    }
}
