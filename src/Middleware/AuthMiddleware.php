<?php

namespace App\Middleware;

use App\Core\Request;
use App\Core\Session;

class AuthMiddleware
{
    public function handle(Request $request): void
    {
        if (!Session::has('user_id')) {
            Session::flash('error', 'Vui lòng đăng nhập để tiếp tục.');
            redirect('/');
        }
    }
}
