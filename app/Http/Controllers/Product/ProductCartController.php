<?php

namespace App\Http\Controllers\Product;

use Inertia\Response;
use App\Models\Product\Cart;
use Illuminate\Http\Request;
use App\Traits\HandleCrudActions;
use App\Http\Requests\CartRequest;
use App\Http\Controllers\Controller;
use App\Services\CartService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ProductCartController extends Controller
{

    use HandleCrudActions;

    protected string $indexInertiaComponent = "Products/Cart";

    protected $cartService;


    public function __construct(CartService $service)
    {
        $this->cartService = $service;
    }

    /**
     * Display All Products
     * 
     * @return Response
     */
    public function index(): Response
    {
        if (!Auth::check()) {
            return to_route('login.index');
        }
        $cart = Cart::query()->where("user_id", auth()->id())->with('product')->get();
        return $this->renderForm($this->indexInertiaComponent, $cart->toArray());
    }


    /**
     * 
     * Add to cart function
     * 
     * @param CartRequest $request a validation for request product cart
     * @return RedirectResponse
     */
    public function store(CartRequest $request): RedirectResponse
    {
        try {
            $this->cartService->store($request->validated());
            return redirect()->back()->with('success', 'Item added to cart successfully!');;
        } catch (\Exception $e) {
            logger()->error('Cart store failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add item to cart. Please try again.');
        }
    }
}
