<?php

namespace App\Services;

use App\Repositories\ClassScheduleRepository;

class ClassScheduleService
{
    public function __construct(private ClassScheduleRepository $repo = new ClassScheduleRepository()) {}
    public function all(): array { return $this->repo->detailed(); }
    public function find(string $id): ?array { return $this->repo->find($id); }
    public function save(array $data, ?string $id = null): string
    {
        $payload = [
            'lecturer_id' => $data['lecturer_id'],
            'room_id' => $data['room_id'],
            'time_slot_id' => $data['time_slot_id'],
            'class_name' => $data['class_name'],
            'subject_name' => $data['subject_name'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'weekday' => $data['weekday'],
            'notes' => $data['notes'] ?? '',
        ];
        if ($id) { $this->repo->update($id, $payload); return $id; }
        return $this->repo->create($payload);
    }
    public function delete(string $id): void { $this->repo->delete($id); }
}
