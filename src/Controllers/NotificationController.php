<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Session;
use App\Services\NotificationService;

class NotificationController
{
    public function index(): string
    {
        $service = new NotificationService();
        $items = auth()->isAdmin() ? $service->all() : $service->forUser(auth()->id());
        return view('notifications/index', ['title' => 'Thông báo', 'notifications' => $items]);
    }

    public function read(Request $request, string $id): void
    {
        (new NotificationService())->markRead($id);
        Session::flash('success', 'Đã đánh dấu đã đọc.');
        redirect('/notifications');
    }
}
