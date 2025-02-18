<?php

namespace App\Http\Controllers\Product;

use App\Enums\OrderStatus;
use App\Models\Order\Order;
use App\Models\Product\Cart;
use Illuminate\Http\Request;
use App\Models\Order\OrderItem;
use App\Models\Product\Product;
use App\Services\CheckoutService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
{


    protected $checkoutService;

    public function __construct(CheckoutService $service)
    {
        $this->checkoutService = $service;
    }

    /**
     * Checking  all cart products.
     * 
     * @param CheckoutRequest $request 
     * @return RedirectResponse
     */
    public function store(CheckoutRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();
            $this->checkoutService->store($validated);
            return redirect()->back()->with('success', 'Checkout successful');
        } catch (\Exception $e) {
            logger()->error('Checkout failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to checkout. Please try again.');
        }
    }
}
