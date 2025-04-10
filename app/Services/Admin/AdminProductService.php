<?php


namespace App\Services\Admin;

use Illuminate\Support\Str;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class AdminProductService 
{

    /**
     * Update a product with validated data.
     * 
     * @param Product $product a product instance
     * @param array $formData the validated data
     * @return Product
     */
    public function update(Product $product, array $formData): Product
    {
        if ($formData['images']) {
            foreach ($formData['images'] as $image) {
                $path = $image->store('products', 'public');
                $imagePaths[] = $path;
            }
        }

        $formData['images'] = $imagePaths;
        
        $product->update($formData);

        return $product;
    }






    /**
     * Stores an product.
     *
     * @param array $formData The validated data request.
     * @return mixed Returns the created product instance or a redirect response
     */
    public function store(array $formData)
    {
        try {
            $imagePaths = [];

            $formData['slug'] = Str::slug($formData['name']);
            if ($formData['images']) {
                foreach ($formData['images'] as $image) {
                    $path = $image->store('products', 'public');
                    $imagePaths[] = $path;
                }
            }

            $formData['images'] = $imagePaths;

            return Product::query()->create($formData);

        } catch (\Exception $e) {
            logger()->error('Failed to create a product: ' . $e->getMessage());
            return null;
        }
    }
}
