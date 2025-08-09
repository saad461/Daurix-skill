<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;

/**
 * Base Controller
 *
 * Provides all controllers with access to Request and Response objects,
 * and helper methods.
 */
abstract class Controller
{
    protected Request $request;
    protected Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Shortcut method to render a view.
     *
     * @param string $view
     * @param array $params
     * @param string $layout
     * @return void
     */
    protected function render(string $view, array $params = [], string $layout = 'main'): void
    {
        $this->response->render($view, $params, $layout);
    }
}
