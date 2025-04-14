<?php


namespace App\Services\Admin;

use Illuminate\Support\Str;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;



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
        $imagePaths = [];
        $formData['slug'] = Str::slug($formData['name']);

        if ($formData['images']) {
            foreach ($formData['images'] as $filename) {
                if (Storage::disk('public')->exists("products/{$filename}")) {
                    $imagePaths[] = "products/{$filename}";
                }
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
        $imagePaths = [];
    
        $formData['slug'] = Str::slug($formData['name']);

        if (!empty($formData['images'])) {
            foreach ($formData['images'] as $filename) {
                if (Storage::disk('public')->exists("products/{$filename}")) {
                    $imagePaths[] = "products/{$filename}";
                }
            }
        }

        $formData['images'] = $imagePaths;

        return Product::query()->create($formData);
    }
}
