<?php

namespace App\Http\Controllers\Auth;

use Inertia\Response;
use App\Services\AuthService;
use App\Traits\HandleCrudActions;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    use HandleCrudActions;

    protected string $indexInertiaComponent = 'Users/Authentication/Register';

    protected string $redirectComponent = 'Users/Home';



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
     * Display a form to register a new user.
     * 
     * @return Response
     */
    public function index(): Response
    {
        return $this->renderForm($this->indexInertiaComponent);
    }

    /**
     * Store a newly created user.
     * 
     * @param RegisterRequest $request get the request
     * 
     * @return RedirectResponse
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        try {
            $this->authService->register($request->validated());

            return to_route('users.home');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to register. Please try again.']);
        }
    }
}
