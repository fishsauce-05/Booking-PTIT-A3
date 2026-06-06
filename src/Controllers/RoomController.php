<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Session;
use App\Services\AmenityService;
use App\Services\RoomService;
use App\Services\TimeSlotService;

class RoomController
{
    public function index(): string {
        return view('rooms/index', [
            'title' => 'Phòng',
            'rooms' => (new RoomService())->all()
        ]);
    }

    public function create(): string {
        return view('rooms/form', [
            'title' => 'Thêm phòng',
            'room' => null
        ]);
    }

    public function store(Request $request): void {
        (new RoomService())->save($request->all());

        Session::flash('success', 'Đã tạo phòng.');

        redirect('/rooms');
    }

    public function show(Request $request, string $id): string {
        $s = new RoomService();

        return view('rooms/show', [
            'title' => 'Chi tiết phòng',
            'room' => $s->find($id),
            'amenities' => $s->amenities($id)
        ]);
    }

    public function edit(Request $request, string $id): string {
        return view('rooms/form', [
            'title' => 'Sửa phòng',
            'room' => (new RoomService())->find($id)
        ]);
    }

    public function update(Request $request, string $id): void {
        (new RoomService())->save($request->all(), $id);

        Session::flash('success', 'Đã cập nhật phòng.');

        redirect('/rooms');
    }

    public function destroy(Request $request, string $id): void {
        (new \App\Repositories\RoomRepository())->delete($id);

        Session::flash('success', 'Đã xóa phòng.');

        redirect('/rooms');
    }

    public function amenities(Request $request, string $id): string {
        return view('rooms/amenities', [
            'title' => 'Tiện ích phòng',
            'room' => (new RoomService())->find($id),
            'roomAmenities' => (new RoomService())->amenities($id),
            'amenities' => (new AmenityService())->all()
        ]);
    }

    public function saveAmenities(Request $request, string $id): void {
        $items = [];

        foreach (($request->input('amenity_id', [])) as $i => $amenityId) {
            $items[] = [
                'amenity_id' => $amenityId,
                'quantity' => $request->input('quantity.' . $i, 1),
                'working_quantity' => $request->input('working_quantity.' . $i, 1),
                'status' => $request->input('status.' . $i, 'available'),
                'note' => $request->input('note.' . $i, ''),
            ];
        }

        (new \App\Repositories\RoomRepository())->syncAmenities($id, $items);

        Session::flash('success', 'Đã cập nhật tiện ích phòng.');

        redirect('/rooms/' . $id);
    }

    public function available(Request $request): string {
        $date = $request->input('date', date('Y-m-d'));
        $slot = $request->input('time_slot_id', '');
        $rooms = $slot
            ? (new RoomService())->available($date, $slot)
            : [];

        return view('rooms/available', [
            'title' => 'Phòng trống',
            'rooms' => $rooms,
            'timeSlots' => (new TimeSlotService())->all(),
            'date' => $date,
            'slot' => $slot
        ]);
    }
}