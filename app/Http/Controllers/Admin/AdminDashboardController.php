<?php

namespace App\Http\Controllers\Admin;

use Inertia\Response;
use Illuminate\Http\Request;
use App\Traits\HandleCrudActions;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    use HandleCrudActions;
    //
    protected string $indexInertiaComponent = 'Admin/Dashboard';

    protected $authService;



    /**
     * Display a dashboard of admin.
     * 
     * @return Response
     */
    public function index(): Response
    {

        return $this->renderForm($this->indexInertiaComponent);
    }
}
