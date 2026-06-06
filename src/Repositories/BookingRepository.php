<?php

namespace App\Repositories;

use App\Core\Database;

class BookingRepository extends BaseRepository
{
    protected string $table = 'bookings';
    protected string $primaryKey = 'booking_id';
    protected array $fillable = ['user_id', 'room_id', 'time_slot_id', 'booking_date', 'status', 'note', 'rejection_reason', 'approved_by', 'approved_at', 'created_at', 'updated_at'];

    public function detailed(string $where = '1=1', array $params = []): array {
        return Database::select(
            "SELECT b.*, u.name AS user_name, r.room_name, r.building, ts.slot_name, ts.start_time, ts.end_time, approver.name AS approver_name
             FROM bookings b
             JOIN users u ON u.user_id = b.user_id
             JOIN rooms r ON r.room_id = b.room_id
             JOIN time_slots ts ON ts.time_slot_id = b.time_slot_id
             LEFT JOIN users approver ON approver.user_id = b.approved_by
             WHERE {$where}
             ORDER BY b.created_at DESC",
            $params
        );
    }

    public function findDetailed(string $id): ?array
    {
        $rows = $this->detailed('b.booking_id = ?', [$id]);
        return $rows[0] ?? null;
    }
}
