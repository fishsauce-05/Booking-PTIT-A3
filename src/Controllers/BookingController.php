<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Session;
use App\Services\BookingService;
use App\Services\RoomService;
use App\Services\TimeSlotService;

class BookingController
{
    public function index(): string {
        return view('bookings/index', [
            'title' => 'Booking',
            'bookings' => (new BookingService())->all()
        ]);
    }

    public function my(): string {
        return view('bookings/my', [
            'title' => 'Booking của tôi',
            'bookings' => (new BookingService())->mine(auth()->id())
        ]);
    }

    public function create(): string {
        return $this->form('Tạo booking');
    }

    public function edit(Request $r, string $id): string {
        return $this->form(
            'Sửa booking',
            (new BookingService())->find($id)
        );
    }

    private function form(
        string $title,
        ?array $booking = null
    ): string {
        return view('bookings/form', [
            'title' => $title,
            'booking' => $booking,
            'rooms' => (new RoomService())->all(),
            'timeSlots' => (new TimeSlotService())->all()
        ]);
    }

    public function store(Request $r): void {
        $bookingService = new BookingService();
        $result = $bookingService->create(
            auth()->id(),
            $r->all()
        );

        Session::flash(
            $result['ok'] ? 'success' : 'error',
            $result['ok']
                ? 'Đã gửi yêu cầu booking.'
                : $result['message']
        );

        redirect('/bookings/my');
    }

    public function update(Request $r, string $id): void {
        $result = (new BookingService())->update(
            $id,
            $r->all()
        );

        Session::flash(
            $result['ok'] ? 'success' : 'error',
            $result['ok']
                ? 'Đã cập nhật booking.'
                : $result['message']
        );

        redirect('/bookings/my');
    }

    public function show(Request $r, string $id): string {
        return view('bookings/show', [
            'title' => 'Chi tiết booking',
            'booking' => (new BookingService())->find($id)
        ]);
    }

    public function approve(Request $r, string $id): void {
        (new BookingService())->approve(
            $id,
            auth()->id()
        );

        Session::flash(
            'success',
            'Đã duyệt booking.'
        );

        redirect('/bookings');
    }

    public function reject(Request $r, string $id): void {
        (new BookingService())->reject(
            $id,
            auth()->id(),
            (string)$r->input('rejection_reason')
        );

        Session::flash(
            'success',
            'Đã từ chối booking.'
        );

        redirect('/bookings');
    }

    public function cancel(Request $r, string $id): void {
        $bookingService = new BookingService();
        $bookingService->cancel($id, auth()->id());

        Session::flash(
            'success',
            'Đã hủy booking.'
        );

        redirect('/bookings/my');
    }
}