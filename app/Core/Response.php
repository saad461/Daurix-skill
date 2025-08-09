<?php

declare(strict_types=1);

namespace App\Core;

class Response
{
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    public function setHeader(string $key, string $value): void
    {
        header("$key: $value");
    }

    public function redirect(string $url, int $statusCode = 302): void
    {
        $this->setStatusCode($statusCode);
        header("Location: $url");
        exit();
    }

    public function json(array $data, int $status = 200): void
    {
        $this->setStatusCode($status);
        $this->setHeader('Content-Type', 'application/json');
        echo json_encode($data);
        exit();
    }

    /**
     * Renders a view with a layout.
     *
     * @param string $view The view file to render (e.g., 'dashboard/index').
     * @param array $params The parameters to pass to the view.
     * @param string $layout The main layout file.
     */
    public function render(string $view, array $params = [], string $layout = 'main'): void
    {
        $viewContent = $this->renderView($view, $params);
        $layoutContent = $this->renderLayout($layout, $params);
        echo str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * Renders just the view file.
     *
     * @param string $view
     * @param array $params
     * @return false|string
     */
    protected function renderView(string $view, array $params): false|string
    {
        // Make variables available to the view file
        extract($params);

        ob_start();
        include_once BASE_PATH . "/templates/pages/$view.php";
        return ob_get_clean();
    }

    /**
     * Renders the layout file.
     *
     * @param string $layout
     * @param array $params
     * @return false|string
     */
    protected function renderLayout(string $layout, array $params): false|string
    {
        // Make variables available to the layout file
        extract($params);

        ob_start();
        include_once BASE_PATH . "/templates/layouts/$layout.php";
        return ob_get_clean();
    }
}
