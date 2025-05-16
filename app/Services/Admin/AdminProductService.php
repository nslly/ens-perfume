<?php


namespace App\Services\Admin;

use Illuminate\Support\Arr;
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
     * @param Product $product The product instance
     * @param array $formData The validated input data
     * @return Product
     */
    public function update(Product $product, array $formData): Product
    {
        $oldImage = $product->image;
        $newImage = $formData['image'] ?? null;

        if ($newImage) {
            $filename = str_replace(['/storage/', url('/storage') . '/'], '', $newImage);

            if (!str_starts_with($filename, 'products/')) {
                $filename = 'products/' . ltrim($filename, '/');
            }

            if ($filename !== $oldImage) {
                if ($oldImage && Storage::exists("public/{$oldImage}")) {
                    Storage::delete("public/{$oldImage}");
                }

                $product->image = $filename;
            }
        }

        $product->fill(Arr::except($formData, ['image']))->save();

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
        $imagePaths = '';
    
        if (!empty($formData['image'])) {
            if (Storage::disk('public')->exists("products/{$formData['image']}")) {
                $imagePaths = "products/{$formData['image']}";
            }
        }
        

        $formData['image'] = $imagePaths;

        return Product::query()->create($formData);
    }
}
