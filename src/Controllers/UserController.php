<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Session;
use App\Services\UserService;

class UserController
{
    public function index(): string {
        return view('users/index', ['title' => 'Người dùng', 'users' => (new UserService())->all()]);
    }

    public function create(): string {
        return view('users/form', ['title' => 'Thêm người dùng', 'user' => null]);
    }

    public function store(Request $request): void {
        (new UserService())->create($request->all());
        Session::flash('success', 'Đã tạo người dùng.');
        redirect('/users');
    }

    public function show(Request $request, string $id): string
    {
        return view('users/show', ['title' => 'Chi tiết người dùng', 'user' => (new UserService())->find($id)]);
    }

    public function edit(Request $request, string $id): string
    {
        return view('users/form', ['title' => 'Sửa người dùng', 'user' => (new UserService())->find($id)]);
    }

    public function update(Request $request, string $id): void
    {
        $data = $request->all();
        if ($id !== auth()->id()) {
            unset($data['name']);
        }
        (new UserService())->update($id, $data);
        Session::flash('success', 'Đã cập nhật người dùng.');
        redirect('/users');
    }

    public function destroy(Request $request, string $id): void
    {
        Session::flash('error', 'Không được xóa người dùng.');
        redirect('/users');
    }

    public function profile(): string
    {
        return view('users/profile', ['title' => 'Hồ sơ', 'user' => (new UserService())->find(auth()->id())]);
    }
}
