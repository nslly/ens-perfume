<?php

namespace App\Http\Middleware;

use App\Http\Resources\Admin\AdminResource;
use Inertia\Middleware;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = Auth::guard('web')->user();
        $admin = Auth::guard('admin')->user();
        $isUser = !is_null($user);
        $isAdmin = !is_null($admin);

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $isUser ? new UserResource($user) : null,
                'isUserAuthenticated' => $isUser,
                'admin' => $isAdmin ? new AdminResource($admin) : null,
                'isAdminAuthenticated' => $isAdmin,
            ],

            'cart_count' => $isUser ? $user->carts()->count() : 0,

            'logo' => asset('icons/logo.png'),
            'flash' => [
                'success' => session()->has('success') ? session('success') : null,
                'error' => session()->has('error') ? session('error') : null,
            ],
        ]);
    }
}
