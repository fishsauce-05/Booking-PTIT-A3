<?php

namespace App\Core;

use App\Repositories\UserRepository;

class Auth
{
    public function check(): bool
    {
        return Session::has('user_id');
    }

    public function id(): ?string
    {
        return Session::get('user_id');
    }

    public function role(): ?string
    {
        return Session::get('role');
    }

    public function user(): ?array
    {
        $id = $this->id();
        return $id ? (new UserRepository())->find($id) : null;
    }

    public function isAdmin(): bool
    {
        return $this->role() === 'admin';
    }
}
