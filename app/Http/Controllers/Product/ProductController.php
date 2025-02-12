<?php

namespace App\Http\Controllers\Product;

use Inertia\Response;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Traits\HandleCrudActions;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    use HandleCrudActions;

    protected string $indexInertiaComponent = "Products/Index";

    /**
     * Display All Products
     * 
     * @return Response
     */
    public function index(): Response
    {
        $products = Product::query()->get();
        return $this->renderForm($this->indexInertiaComponent, $products->toArray());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
