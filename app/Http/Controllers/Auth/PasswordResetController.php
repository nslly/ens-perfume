<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class PasswordResetController extends Controller
{

    protected $authService;

    /**
     *  AuthService constructor
     * 
     * @param AuthService $service
     * 
     */
    public function __construct(AuthService $service)
    {
        $this->authService = $service;
    }

    /**
     * Handle the forgot password request.
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        try {
            $this->authService->sendResetLink($request->only('email'));
            return to_route('users.home')->with('success', 'Password reset link sent to your email.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Something went wrong.']);
        }
    }


    /**
     * Handle the reset password request.
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function reset(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $this->authService->resetPassword($validated);

            return to_route('users.home')->with('success', 'Password reset password successfull.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Something went wrong.']);
        }
    }
}
