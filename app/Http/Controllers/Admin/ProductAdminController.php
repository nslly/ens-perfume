<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Product\Category;
use App\Traits\HandleCrudActions;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Resources\ProductResource;
use App\Services\Admin\AdminProductService;

class ProductAdminController extends Controller
{
    use HandleCrudActions;

    protected string $indexInertiaComponent = "Admin/Products/Index";
    protected string $createInertiaComponent = "Admin/Products/Create";
    protected string $editInertiaComponent = "Admin/Products/Edit";

    protected $productService;



    public function __construct(AdminProductService $service)
    {
        $this->productService = $service;
    }



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
     * @param Request $request a request object
     * @return Response
     */
    public function index(Request $request): Response
    {

        try {
            $products = Product::query()->with($this->getRelationships())
                ->latest()
                ->paginate(6);
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


    /**
     * Show the form for creating a new products in admin dashboard
     * 
     * @return Response
     */
    public function create(): Response
    {
        $categories = Category::all(['slug', 'name']);
        $brands = Brand::all(['id', 'name', 'logo']);

        return $this->renderForm($this->createInertiaComponent, [
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }


    
    /**
     * Store a newly created products in admin dashboard
     * 
     * @param ProductRequest $request a request object
     * @return RedirectResponse
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        try {
            dd($request);
            $this->productService->store($request->validated());
            return redirect()->back()->with('success', 'Product created successfully!');;
        } catch (\Exception $e) {
            logger()->error('Cart store failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create a product. Please try again.');
        }
    }


    /**
     * Edit the form for created products in admin dashboard
     * 
     * @return Response
     */
    public function edit(Product $product): Response
    {
        return $this->renderForm($this->editInertiaComponent, ['product' => $product]);
    }


    /**
     * Update the form for created products in admin dashboard
     * 
     * @param ProductRequest $request a request object
     * @param Product $product a product object
     * @return RedirectResponse
     * 
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        try {
            $this->productService->update($product, $request->validated());
            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to update. Please try again.');
        }
    }


    /**
     * Remove the specified resource from storage.
     * 
     * @param Product $product a product object
     * @return RedirectResponse
     * 
     */
    public function destroy(Product $product): RedirectResponse
    {
        try {
            $product->delete();
            return redirect()->back()->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete. Please try again.');
        }
    }
}
