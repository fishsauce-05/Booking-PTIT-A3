<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Session;
use App\Services\TimeSlotService;

class TimeSlotController
{
    public function index(): string { return view('time-slots/index', ['title' => 'Ca học', 'timeSlots' => (new TimeSlotService())->all()]); }
    public function create(): string { return view('time-slots/create', ['title' => 'Thêm ca học']); }
    public function store(Request $r): void { (new TimeSlotService())->save($r->all()); Session::flash('success', 'Đã tạo ca học.'); redirect('/time-slots'); }
    public function edit(Request $r, string $id): string { return view('time-slots/edit', ['title' => 'Sửa ca học', 'slot' => (new TimeSlotService())->find($id)]); }
    public function update(Request $r, string $id): void { (new TimeSlotService())->save($r->all(), $id); Session::flash('success', 'Đã cập nhật ca học.'); redirect('/time-slots'); }
    public function destroy(Request $r, string $id): void { (new TimeSlotService())->delete($id); Session::flash('success', 'Đã xóa ca học.'); redirect('/time-slots'); }
}
