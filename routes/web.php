<?php

use App\Controllers\AmenityController;
use App\Controllers\AuthController;
use App\Controllers\BookingController;
use App\Controllers\ClassScheduleController;
use App\Controllers\DashboardController;
use App\Controllers\NotificationController;
use App\Controllers\RoomController;
use App\Controllers\TimeSlotController;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;

$auth = [AuthMiddleware::class];
$admin = [AuthMiddleware::class, RoleMiddleware::class];

$router->get('/', [AuthController::class, 'login']);
$router->get('/login', fn() => redirect('/'));
$router->post('/login', [AuthController::class, 'authenticate']);
$router->get('/forgot-password', [AuthController::class, 'forgot']);
$router->post('/logout', [AuthController::class, 'logout'], $auth);
$router->get('/change-password', [AuthController::class, 'changePassword'], $auth);
$router->post('/change-password', [AuthController::class, 'updatePassword'], $auth);

$router->get('/dashboard', [DashboardController::class, 'index'], $auth);
$router->get('/profile', [UserController::class, 'profile'], $auth);

$router->get('/users', [UserController::class, 'index'], $admin);
$router->get('/users/create', [UserController::class, 'create'], $admin);
$router->post('/users', [UserController::class, 'store'], $admin);
$router->get('/users/{id}', [UserController::class, 'show'], $admin);
$router->get('/users/{id}/edit', [UserController::class, 'edit'], $admin);
$router->put('/users/{id}', [UserController::class, 'update'], $admin);

$router->get('/rooms', [RoomController::class, 'index'], $auth);
$router->get('/rooms/available', [RoomController::class, 'available'], $auth);
$router->get('/rooms/create', [RoomController::class, 'create'], $admin);
$router->post('/rooms', [RoomController::class, 'store'], $admin);
$router->get('/rooms/{id}', [RoomController::class, 'show'], $auth);
$router->get('/rooms/{id}/edit', [RoomController::class, 'edit'], $admin);
$router->put('/rooms/{id}', [RoomController::class, 'update'], $admin);
$router->delete('/rooms/{id}', [RoomController::class, 'destroy'], $admin);
$router->get('/rooms/{id}/amenities', [RoomController::class, 'amenities'], $admin);
$router->post('/rooms/{id}/amenities', [RoomController::class, 'saveAmenities'], $admin);

$router->get('/amenities', [AmenityController::class, 'index'], $admin);
$router->get('/amenities/create', [AmenityController::class, 'create'], $admin);
$router->post('/amenities', [AmenityController::class, 'store'], $admin);
$router->get('/amenities/{id}/edit', [AmenityController::class, 'edit'], $admin);
$router->put('/amenities/{id}', [AmenityController::class, 'update'], $admin);
$router->delete('/amenities/{id}', [AmenityController::class, 'destroy'], $admin);

$router->get('/time-slots', [TimeSlotController::class, 'index'], $admin);
$router->get('/time-slots/create', [TimeSlotController::class, 'create'], $admin);
$router->post('/time-slots', [TimeSlotController::class, 'store'], $admin);
$router->get('/time-slots/{id}/edit', [TimeSlotController::class, 'edit'], $admin);
$router->put('/time-slots/{id}', [TimeSlotController::class, 'update'], $admin);
$router->delete('/time-slots/{id}', [TimeSlotController::class, 'destroy'], $admin);

$router->get('/schedules', [ClassScheduleController::class, 'index'], $admin);
$router->get('/schedules/import', [ClassScheduleController::class, 'import'], $admin);
$router->get('/schedules/create', [ClassScheduleController::class, 'create'], $admin);
$router->post('/schedules', [ClassScheduleController::class, 'store'], $admin);
$router->get('/schedules/{id}/edit', [ClassScheduleController::class, 'edit'], $admin);
$router->put('/schedules/{id}', [ClassScheduleController::class, 'update'], $admin);
$router->delete('/schedules/{id}', [ClassScheduleController::class, 'destroy'], $admin);

$router->get('/bookings', [BookingController::class, 'index'], $admin);
$router->get('/bookings/my', [BookingController::class, 'my'], $auth);
$router->get('/bookings/create', [BookingController::class, 'create'], $auth);
$router->post('/bookings', [BookingController::class, 'store'], $auth);
$router->get('/bookings/{id}', [BookingController::class, 'show'], $auth);
$router->get('/bookings/{id}/edit', [BookingController::class, 'edit'], $auth);
$router->put('/bookings/{id}', [BookingController::class, 'update'], $auth);
$router->post('/bookings/{id}/approve', [BookingController::class, 'approve'], $admin);
$router->post('/bookings/{id}/reject', [BookingController::class, 'reject'], $admin);
$router->post('/bookings/{id}/cancel', [BookingController::class, 'cancel'], $auth);

$router->get('/notifications', [NotificationController::class, 'index'], $auth);
$router->post('/notifications/{id}/read', [NotificationController::class, 'read'], $auth);
