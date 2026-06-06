<?php

namespace App\Services;

use App\Core\Database;
use App\Repositories\RoomRepository;

class RoomService
{
    public function __construct(private RoomRepository $rooms = new RoomRepository()) {}

    public function all(): array
    {
        return $this->rooms->all('building, floor, room_name');
    }

    public function find(string $id): ?array
    {
        return $this->rooms->find($id);
    }

    public function amenities(string $id): array
    {
        return $this->rooms->amenities($id);
    }

    public function save(array $data, ?string $id = null): string
    {
        $payload = [
            'room_name' => $data['room_name'],
            'building' => $data['building'],
            'floor' => (int)$data['floor'],
            'capacity' => (int)$data['capacity'],
            'room_type' => $data['room_type'],
            'is_active' => isset($data['is_active']) ? 1 : 0,
        ];
        if ($id) {
            $this->rooms->update($id, $payload);
            return $id;
        }
        return $this->rooms->create($payload);
    }

    public function available(string $date, string $timeSlotId): array
    {
        return Database::select(
            "SELECT * FROM rooms r
             WHERE r.is_active = 1
             AND NOT EXISTS (
                SELECT 1 FROM bookings b
                WHERE b.room_id = r.room_id AND b.time_slot_id = ? AND b.booking_date = ? AND b.status IN ('pending','approved')
             )
             AND NOT EXISTS (
                SELECT 1 FROM class_schedules cs
                WHERE cs.room_id = r.room_id AND cs.time_slot_id = ? AND ? BETWEEN cs.start_date AND cs.end_date
             )
             ORDER BY r.building, r.floor, r.room_name",
            [$timeSlotId, $date, $timeSlotId, $date]
        );
    }
}
