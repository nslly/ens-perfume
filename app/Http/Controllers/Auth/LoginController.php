<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Traits\HandleCrudActions;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;

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
     * @return Response 
     */
    public function store(LoginRequest $request): Response
    {

        if ($this->authService->login($request->validated())) {
            return $this->renderForm($this->indexInertiaComponent);
        }

        return back()->withErrors(['error' => 'Invalid credentials.']);
    }

    /**
     * logout the current user.
     * 
     * @return Response
     */
    public function destroy(): Response
    {
        $this->authService->logout();
        return $this->renderForm('Home');
    }
}
