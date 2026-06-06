<?php

namespace App\Controllers;

use App\Core\Database;

class DashboardController
{
    public function index(): string
    {
        $stats = [
            'rooms' => Database::first('SELECT COUNT(*) count FROM rooms')['count'] ?? 0,
            'bookings' => Database::first('SELECT COUNT(*) count FROM bookings')['count'] ?? 0,
            'pending' => Database::first("SELECT COUNT(*) count FROM bookings WHERE status = 'pending'")['count'] ?? 0,
            'users' => Database::first('SELECT COUNT(*) count FROM users')['count'] ?? 0,
        ];
        $recent = (new \App\Services\BookingService())->all();
        return view('dashboard/index', ['title' => 'Dashboard', 'stats' => $stats, 'recent' => array_slice($recent, 0, 5)]);
    }
}
