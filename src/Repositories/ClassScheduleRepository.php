<?php

namespace App\Repositories;

use App\Core\Database;

class ClassScheduleRepository extends BaseRepository
{
    protected string $table = 'class_schedules';
    protected string $primaryKey = 'class_schedule_id';
    protected array $fillable = ['lecturer_id', 'room_id', 'time_slot_id', 'class_name', 'subject_name', 'start_date', 'end_date', 'weekday', 'notes'];

    public function detailed(): array
    {
        return Database::select(
            'SELECT cs.*, r.room_name, ts.slot_name, u.name AS lecturer_name
             FROM class_schedules cs
             JOIN rooms r ON r.room_id = cs.room_id
             JOIN time_slots ts ON ts.time_slot_id = cs.time_slot_id
             JOIN lecturers l ON l.lecturer_id = cs.lecturer_id
             JOIN users u ON u.user_id = l.user_id
             ORDER BY cs.start_date DESC'
        );
    }
}
