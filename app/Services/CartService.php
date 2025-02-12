<?php

namespace App\Services;

use App\Models\Product\Cart;
use Illuminate\Support\Facades\DB;

class CartService
{

    /**
     * Stores an item in the cart.
     *
     * @param array $formData The validated data request.
     * @return Cart|null Returns the created Cart instance or null if failed.
     */
    public function store(array $formData): ?Cart
    {
        try {
            return DB::transaction(function () use ($formData) {
                return Cart::updateOrCreate(
                    [
                        'user_id' => auth()->user()->id,
                        'product_id' => $formData['product_id'],
                        'price' => $formData['price'],
                    ],
                    ['quantity' => DB::raw('quantity + ' . $formData['quantity'])]
                );
            });
        } catch (\Exception $e) {
            logger()->error('Cart store failed: ' . $e->getMessage());
            return null;
        }
    }
}
