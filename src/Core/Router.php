<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, array|callable $handler, array $middleware = []): void
    {
        $this->add('GET', $path, $handler, $middleware);
    }

    public function post(string $path, array|callable $handler, array $middleware = []): void
    {
        $this->add('POST', $path, $handler, $middleware);
    }

    public function put(string $path, array|callable $handler, array $middleware = []): void
    {
        $this->add('PUT', $path, $handler, $middleware);
    }

    public function delete(string $path, array|callable $handler, array $middleware = []): void
    {
        $this->add('DELETE', $path, $handler, $middleware);
    }

    private function add(string $method, string $path, array|callable $handler, array $middleware): void
    {
        $this->routes[] = compact('method', 'path', 'handler', 'middleware');
    }

    public function dispatch(): void
    {
        $request = new Request();
        $request->validateCsrf();

        foreach ($this->routes as $route) {
            $params = $this->match($route['path'], $request->path());
            if ($route['method'] === $request->method() && $params !== null) {
                foreach ($route['middleware'] as $middleware) {
                    (new $middleware())->handle($request);
                }
                $response = $this->call($route['handler'], $request, $params);
                if (is_string($response)) {
                    echo $response;
                }
                return;
            }
        }

        http_response_code(404);
        echo view('errors/404', ['title' => 'Không tìm thấy'], 'guest');
    }

    private function match(string $routePath, string $requestPath): ?array
    {
        $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $routePath);
        $pattern = '#^' . rtrim($pattern, '/') . '$#';
        if ($routePath === '/') {
            $pattern = '#^/$#';
        }
        if (!preg_match($pattern, $requestPath, $matches)) {
            return null;
        }
        return array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
    }

    private function call(array|callable $handler, Request $request, array $params): mixed
    {
        if (is_callable($handler)) {
            return $handler($request, ...array_values($params));
        }
        [$class, $method] = $handler;
        return (new $class())->$method($request, ...array_values($params));
    }
}
