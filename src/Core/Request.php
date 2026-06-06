<?php

namespace App\Core;

class Request
{
    public function method(): string
    {
        $method = strtoupper($_POST['_method'] ?? $_SERVER['REQUEST_METHOD'] ?? 'GET');
        return in_array($method, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'], true) ? $method : 'GET';
    }

    public function path(): string
    {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        return rtrim($path, '/') ?: '/';
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($_GET, $_POST);
    }

    public function only(array $keys): array
    {
        $data = [];
        foreach ($keys as $key) {
            if (array_key_exists($key, $_POST)) {
                $data[$key] = is_string($_POST[$key]) ? trim($_POST[$key]) : $_POST[$key];
            }
        }
        return $data;
    }

    public function validateCsrf(): void
    {
        if ($this->method() === 'GET') {
            return;
        }
        $token = $_POST['_csrf'] ?? '';
        if (!$token || !hash_equals((string)Session::get('_csrf'), (string)$token)) {
            http_response_code(419);
            exit('CSRF token mismatch.');
        }
    }
}
