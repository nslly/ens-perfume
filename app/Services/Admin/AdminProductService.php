<?php


namespace App\Services\Admin;

use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class AdminProductService 
{

    /**
     * Update a product with validated data.
     * 
     * @param Product $product a product instance
     * @param array $validatedData the validated data
     * @return Product
     */
    public function update(Product $product, array $validatedData): Product
    {
        return DB::transaction(function () use ($product, $validatedData) {
            $product->update($validatedData);

            return $product;
        });
    }
}
