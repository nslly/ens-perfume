<?php

namespace App\Traits;

use Inertia\Inertia;
use Inertia\Response;

trait HandleCrudActions
{
    /**
     * Renders the form view for create or edit actions.
     *
     * @param string $view the Inertia component path
     * @param array $data data to pass to the component
     *
     * @return Response
     */
    protected function renderForm(string $view, array $data = []): Response
    {
        return Inertia::render($view, $data);
    }
}
