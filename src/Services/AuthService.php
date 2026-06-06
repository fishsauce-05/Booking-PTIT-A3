<?php

namespace App\Services;

use App\Core\Session;
use App\Repositories\UserRepository;

class AuthService
{
    public function attempt(string $email, string $password): bool
    {
        $user = (new UserRepository())->findByEmail($email);
        if (!$user || !(int)$user['is_active'] || !password_verify($password, $user['password_hash'])) {
            return false;
        }
        Session::put('user_id', $user['user_id']);
        Session::put('role', $user['role']);
        return true;
    }

    public function logout(): void
    {
        Session::destroy();
    }
}
