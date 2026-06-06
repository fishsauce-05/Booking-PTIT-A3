<?php

namespace App\Middleware;

use App\Core\Request;
use App\Core\Session;

class RoleMiddleware
{
    public function handle(Request $request): void
    {
        if (Session::get('role') !== 'admin') {
            http_response_code(403);
            echo view('errors/403', ['title' => 'Không có quyền'], 'app');
            exit;
        }
    }
}
