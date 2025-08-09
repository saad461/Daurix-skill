<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    protected array $routes = [];
    protected Request $request;
    protected Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, $callback, array $middleware = []): void
    {
        $this->addRoute('get', $path, $callback, $middleware);
    }

    public function post(string $path, $callback, array $middleware = []): void
    {
        $this->addRoute('post', $path, $callback, $middleware);
    }

    public function addRoute(string $method, string $path, $callback, array $middleware = []): void
    {
        $this->routes[$method][$path] = ['callback' => $callback, 'middleware' => $middleware];
    }

    public function dispatch(): void
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $route = $this->findRoute($method, $path);

        if (!$route) {
            $this->response->setStatusCode(404);
            // In a real app, you would render a dedicated 404 page
            echo "404 - Not Found";
            return;
        }

        $params = $this->getRouteParams($route['path'], $path);
        $callback = $route['callback'];
        $middlewares = $route['middleware'];

        // Execute middlewares
        foreach ($middlewares as $middleware) {
            (new $middleware())->handle($this->request);
        }

        if (is_array($callback)) {
            $controller = new $callback[0]($this->request, $this->response);
            $callback[0] = $controller;
        }

        call_user_func($callback, ...array_values($params));
    }

    protected function findRoute(string $method, string $path): ?array
    {
        foreach ($this->routes[$method] ?? [] as $routePath => $data) {
            $pattern = $this->convertRouteToRegex($routePath);
            if (preg_match($pattern, $path)) {
                return ['path' => $routePath, 'callback' => $data['callback'], 'middleware' => $data['middleware']];
            }
        }
        return null;
    }

    protected function convertRouteToRegex(string $routePath): string
    {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_-]+)', $routePath);
        return "#^" . $pattern . "$#";
    }

    protected function getRouteParams(string $routePath, string $path): array
    {
        $params = [];
        $pattern = $this->convertRouteToRegex($routePath);
        if (preg_match($pattern, $path, $matches)) {
            foreach ($matches as $key => $value) {
                if (is_string($key)) {
                    $params[$key] = $value;
                }
            }
        }
        return $params;
    }
}
