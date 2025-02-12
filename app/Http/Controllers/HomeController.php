<?php

namespace App\Http\Controllers;

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
    public function index(): Response
    {
        $products = Product::query()->limit(6)->get();
        return $this->renderForm($this->indexInertiaComponent, $products->toArray());
    }
}
