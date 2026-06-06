<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Session;
use App\Services\AuthService;
use App\Services\UserService;

class AuthController
{
    public function login(): string
    {
        return view('auth/login', ['title' => 'Đăng nhập'], 'guest');
    }

    public function authenticate(Request $request): void
    {
        $ok = (new AuthService())->attempt((string)$request->input('email'), (string)$request->input('password'));
        if (!$ok) {
            Session::flash('error', 'Email hoặc mật khẩu không đúng.');
            redirect('/');
        }
        redirect('/dashboard');
    }

    public function logout(): void
    {
        (new AuthService())->logout();
        redirect('/');
    }

    public function forgot(): string
    {
        return view('auth/forgot-password', ['title' => 'Quên mật khẩu'], 'guest');
    }

    public function changePassword(): string
    {
        return view('auth/change-password', ['title' => 'Đổi mật khẩu']);
    }

    public function updatePassword(Request $request): void
    {
        $password = (string)$request->input('password');
        if (strlen($password) < 6 || $password !== $request->input('password_confirmation')) {
            Session::flash('error', 'Mật khẩu phải từ 6 ký tự và xác nhận khớp nhau.');
            redirect('/change-password');
        }
        (new UserService())->changePassword(auth()->id(), $password);
        Session::flash('success', 'Đã đổi mật khẩu.');
        redirect('/dashboard');
    }
}
