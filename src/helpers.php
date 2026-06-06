<?php

use App\Core\Auth;
use App\Core\Session;
use App\Core\View;

if (!function_exists('base_path')) {
    function base_path(string $path = ''): string
    {
        $base = dirname(__DIR__);
        return $path ? $base . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path) : $base;
    }
}

if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        return $_ENV[$key] ?? $_SERVER[$key] ?? $default;
    }
}

if (!function_exists('config')) {
    function config(string $key, mixed $default = null): mixed
    {
        static $configs = [];
        [$file, $item] = array_pad(explode('.', $key, 2), 2, null);
        if (!isset($configs[$file])) {
            $path = base_path("config/{$file}.php");
            $configs[$file] = is_file($path) ? require $path : [];
        }
        return $item === null ? $configs[$file] : ($configs[$file][$item] ?? $default);
    }
}

if (!function_exists('view')) {
    function view(string $template, array $data = [], string $layout = 'app'): string
    {
        return View::render($template, $data, $layout);
    }
}

if (!function_exists('redirect')) {
    function redirect(string $to): void
    {
        header("Location: {$to}");
        exit;
    }
}

if (!function_exists('route_is')) {
    function route_is(string $path): bool
    {
        return parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) === $path;
    }
}

if (!function_exists('e')) {
    function e(mixed $value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        if (!Session::has('_csrf')) {
            Session::put('_csrf', bin2hex(random_bytes(32)));
        }
        return Session::get('_csrf');
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
    }
}

if (!function_exists('method_field')) {
    function method_field(string $method): string
    {
        return '<input type="hidden" name="_method" value="' . e(strtoupper($method)) . '">';
    }
}

if (!function_exists('auth')) {
    function auth(): Auth
    {
        return new Auth();
    }
}
