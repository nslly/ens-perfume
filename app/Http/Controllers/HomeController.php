<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Traits\HandleCrudActions;

class HomeController extends Controller
{
    use HandleCrudActions;

    protected string $indexInertiaComponent = "Users/Home";

    /**
     * Display Home Page
     * 
     * @return Response
     */
    public function index(Request $request): Response
    {
        $products = Product::query()->where('quantity', '>', 0)->limit(6)->latest()->get();
        $productResource = ProductResource::collection($products)->toArray($request);
        return $this->renderForm($this->indexInertiaComponent, $productResource);
    }
}
