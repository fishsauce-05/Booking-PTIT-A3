<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Session;
use App\Services\AmenityService;

class AmenityController
{
    public function index(): string
    {
        return view('amenities/index', [
            'title' => 'Tiện ích',
            'amenities' => (new AmenityService())->all()
        ]);
    }

    public function create(): string
    {
        return view('amenities/create', [
            'title' => 'Thêm tiện ích'
        ]);
    }

    public function store(Request $r): void
    {
        (new AmenityService())->save($r->all());

        Session::flash('success', 'Đã tạo tiện ích.');

        redirect('/amenities');
    }

    public function edit(Request $r, string $id): string
    {
        return view('amenities/edit', [
            'title' => 'Sửa tiện ích',
            'amenity' => (new AmenityService())->find($id)
        ]);
    }

    public function update(Request $r, string $id): void
    {
        (new AmenityService())->save($r->all(), $id);

        Session::flash('success', 'Đã cập nhật tiện ích.');

        redirect('/amenities');
    }

    public function destroy(Request $r, string $id): void
    {
        (new AmenityService())->delete($id);

        Session::flash('success', 'Đã xóa tiện ích.');

        redirect('/amenities');
    }
}