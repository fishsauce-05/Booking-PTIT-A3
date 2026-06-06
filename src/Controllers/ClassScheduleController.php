<?php

namespace App\Controllers;

use App\Core\Database;
use App\Core\Request;
use App\Core\Session;
use App\Services\ClassScheduleService;
use App\Services\RoomService;
use App\Services\TimeSlotService;

class ClassScheduleController
{
    public function index(): string { return view('schedules/index', ['title' => 'Lịch lớp', 'schedules' => (new ClassScheduleService())->all()]); }
    public function create(): string { return $this->form('Thêm lịch lớp'); }
    public function edit(Request $r, string $id): string { return $this->form('Sửa lịch lớp', (new ClassScheduleService())->find($id)); }
    private function form(string $title, ?array $schedule = null): string
    {
        return view('schedules/form', [
            'title' => $title,
            'schedule' => $schedule,
            'rooms' => (new RoomService())->all(),
            'timeSlots' => (new TimeSlotService())->all(),
            'lecturers' => Database::select('SELECT l.*, u.name FROM lecturers l JOIN users u ON u.user_id = l.user_id ORDER BY u.name'),
        ]);
    }
    public function store(Request $r): void { (new ClassScheduleService())->save($r->all()); Session::flash('success', 'Đã tạo lịch lớp.'); redirect('/schedules'); }
    public function update(Request $r, string $id): void { (new ClassScheduleService())->save($r->all(), $id); Session::flash('success', 'Đã cập nhật lịch lớp.'); redirect('/schedules'); }
    public function destroy(Request $r, string $id): void { (new ClassScheduleService())->delete($id); Session::flash('success', 'Đã xóa lịch lớp.'); redirect('/schedules'); }
    public function import(): string { return view('schedules/import', ['title' => 'Import lịch lớp']); }
}
