<?php

namespace App\Traits;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
        return Inertia::render($view, ['items' => $data]);
    }


    /**
     * Set a paginated data
     * 
     * @param AnonymousResourceCollection $resource a resource data
     * @param LengthAwarePaginator $paginate a data want to paginate
     * @return array
     * 
     */
    public function setItemsAndPaginate(AnonymousResourceCollection $resource, LengthAwarePaginator $paginate): array
    {
        return [
            'resource' => $resource,
            'pagination' => [
                'current_page' => $paginate->currentPage(),
                'last_page' => $paginate->lastPage(),
                'per_page' => $paginate->perPage(),
                'total' => $paginate->total(),
                'next_page_url' => $paginate->nextPageUrl(),
                'prev_page_url' => $paginate->previousPageUrl(),
            ],
        ];
    }
}
