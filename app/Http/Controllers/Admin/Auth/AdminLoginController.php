<?php

namespace App\Http\Controllers\Admin\Auth;

use Inertia\Response;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Traits\HandleCrudActions;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{

    use HandleCrudActions;

    protected string $indexInertiaComponent = 'Admin/Authentication/Login';

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
     * Display a form to log in a admin.
     * 
     * @return Response
     */
    public function index(): Response
    {
        return $this->renderForm($this->indexInertiaComponent);
    }



    /** Store a login admin.
     * 
     * @param LoginRequest $request get the request
     * 
     * @return RedirectResponse
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            if ($this->authService->login($request->validated(), 'admin')) {
                return to_route('admin.dashboard')->with('success', "Login Successful.");
            }
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }



    /**
     * logout the current admin.
     * 
     * @return RedirectResponse
     */
    public function destroy(): RedirectResponse
    {
        try {
            $this->authService->logout();

            return to_route('admin.login')->with('success', "Logout Successful.");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to logout.');
        }
    }
}
