<?php

namespace App\Http\Controllers\Admin;

use Inertia\Response;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Traits\HandleCrudActions;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Services\AdminProductService;

class ProductAdminController extends Controller
{
    use HandleCrudActions;

    protected string $indexInertiaComponent = "Admin/Products/Index";

    protected $productService;



    // public function __construct(AdminProductService $service)
    // {
    //     $this->productService = $service;
    // }



    /**
     * 
     * Get the relationships in the Cart model
     * @return array
     */
    protected function getRelationships(): array
    {
        return [
            'category',
            'brand'
        ];
    }



    // /**
    //  * Get the cart for the authenticated user
    //  * @return Collection
    //  */
    // private function getProduct(): Collection
    // {
    //     return Product::query()->with($this->getRelationships())
    //         ->latest()
    //         ->get();
    // }



    /**
     * Display All Products
     * 
     * @return Response
     */
    public function index(Request $request): Response
    {

        try {
            $products = Product::query()->with($this->getRelationships())
                ->latest()
                ->paginate(8);
            $productsResource = ProductResource::collection($products);
            return $this->renderForm(
                $this->indexInertiaComponent,
                $this->setItemsAndPaginate($productsResource, $products)
            );
        } catch (\Exception $e) {
            Log::error('Error fetching products: ' . $e->getMessage());
            return $this->renderForm($this->indexInertiaComponent, ['error' => 'Unable to fetch products.']);
        }
    }
}
