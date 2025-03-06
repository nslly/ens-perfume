<?php

namespace App\Services;

use App\Models\Product\Cart;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProductCartResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartService
{


    /**
     * 
     * Set the resource for Cart Model
     * 
     * @param Request $request 
     * @param Collection $query
     * 
     * @return array
     */
    public function indexCart(Request $request, Collection $query): array
    {
        return ProductCartResource::collection($query)->toArray($request);
    }


    /**
     * Updating the cart model 
     * 
     * @param Cart $cart
     * @param array $formData
     * @return Cart
     */
    public function update(Cart $cart, array $formData): Cart
    {
        $cart->update([
            'quantity' => $formData['quantity'],
        ]);

        return $cart;
    }


    /**
     * Stores an item in the cart.
     *
     * @param array $formData The validated data request.
     * @return mixed Returns the created Cart instance or a redirect response
     */
    public function store(array $formData)
    {
        try {
            return DB::transaction(function () use ($formData) {
                $userId = auth()->user()->id;
                $product = Product::query()->find($formData['product_id']);

                if (!$product) {
                    return redirect()->back()->with('error', 'Product not found.');
                }

                $existingCart = Cart::query()->where('user_id', $userId)
                    ->where('product_id', $formData['product_id'])
                    ->first();

                $newQuantity = $existingCart ? $existingCart->quantity + $formData['quantity'] : $formData['quantity'];

                if ($newQuantity > $product->quantity) {
                    return redirect()->back()->with('error', "Cannot add more than available stock.");
                }
                return Cart::query()->updateOrCreate(
                    [
                        'user_id' => $userId,
                        'product_id' => $formData['product_id'],
                        'price' => $formData['price'],
                    ],
                    ['quantity' => $newQuantity]
                );
            });
        } catch (\Exception $e) {
            logger()->error('Cart store failed: ' . $e->getMessage());
            return null;
        }
    }
}
