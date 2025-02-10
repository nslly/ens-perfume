<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Traits\HandleCrudActions;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    use HandleCrudActions;

    protected $authService;

    protected string $indexInertiaComponent = 'Users/Authentication/Login';

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
     * Display a form to log in a user.
     * 
     * @return Response
     */
    public function index(): Response
    {
        return $this->renderForm($this->indexInertiaComponent);
    }

    /** Store a login user.
     * 
     * @param LoginRequest $request get the request
     * 
     * @return RedirectResponse
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            if ($this->authService->login($request->validated())) {
                return to_route('users.home');
            }
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Something went wrong. Please try again.']);
        }
    }

    /**
     * logout the current user.
     * 
     * @return RedirectResponse
     */
    public function destroy(): RedirectResponse
    {
        try {
            $this->authService->logout();

            return to_route('users.home');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to logout.']);
        }
    }
}
