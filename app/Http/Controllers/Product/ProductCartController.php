<?php

namespace App\Http\Controllers\Product;

use Exception;
use Inertia\Response;
use App\Models\Product\Cart;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Traits\HandleCrudActions;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CartRequest;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCartRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Query\Builder;
use App\Http\Resources\ProductCartResource;

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
     * 
     * Get the relationships in the Cart model
     * @return array
     */
    protected function getRelationships(): array
    {
        return [
            'product',
            'user'
        ];
    }

    /**
     * Get the cart for the authenticated user
     * @return Collection
     */
    private function getCart(): Collection
    {
        return Cart::with($this->getRelationships())
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    /**
     * Display All Products
     * @param Request $request 
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Auth::check()
            ? $this->renderForm(
                $this->indexInertiaComponent,
                $this->cartService->indexCart($request, $this->getCart())
            )
            : to_route('login.index');
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

    /**
     * Updating the quantity of the cart
     * 
     * @param CartRequest $request a validated request 
     * @param Cart $cart a model of product cart
     * @return RedirectResponse
     */
    public function update(UpdateCartRequest $request, Cart $cart): RedirectResponse
    {
        $validatedData = $request->validated();

        try {
            $this->cartService->update($cart, $validatedData);
            return redirect()->back();
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to update. Please try again.');
        }
    }

    /**
     * Deleting items on cart table
     * 
     * @param Cart $cart
     * @return RedirectResponse
     */
    public function destroy(Cart $cart): RedirectResponse
    {
        try {
            $cart->delete();
            return redirect()->back()->with('success', 'Item removed successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to remove item to cart. Please try again.');
        }
    }
}
