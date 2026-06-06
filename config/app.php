<?php

return [
    'name' => env('APP_NAME', 'PTIT Booking'),
    'url' => env('APP_URL', 'http://127.0.0.1:8000'),
    'env' => env('APP_ENV', 'local'),
    'debug' => filter_var(env('APP_DEBUG', true), FILTER_VALIDATE_BOOL),
];
