<?php

namespace App\Repositories;

use App\Core\Database;

class RoomRepository extends BaseRepository
{
    protected string $table = 'rooms';
    protected string $primaryKey = 'room_id';
    protected array $fillable = ['room_name', 'building', 'floor', 'capacity', 'room_type', 'is_active'];

    public function amenities(string $roomId): array
    {
        return Database::select('SELECT ra.*, a.name FROM room_amenities ra JOIN amenities a ON a.amenity_id = ra.amenity_id WHERE ra.room_id = ?', [$roomId]);
    }

    public function syncAmenities(string $roomId, array $amenities): void
    {
        Database::statement('DELETE FROM room_amenities WHERE room_id = ?', [$roomId]);
        foreach ($amenities as $amenity) {
            if (empty($amenity['amenity_id'])) {
                continue;
            }
            Database::statement(
                'INSERT INTO room_amenities (room_id, amenity_id, quantity, working_quantity, status, note) VALUES (?, ?, ?, ?, ?, ?)',
                [$roomId, $amenity['amenity_id'], $amenity['quantity'] ?: 1, $amenity['working_quantity'] ?: 1, $amenity['status'] ?: 'available', $amenity['note'] ?? '']
            );
        }
    }
}
