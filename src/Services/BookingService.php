<?php

namespace App\Services;

use App\Core\Database;
use App\Repositories\BookingRepository;

class BookingService
{
    public function __construct(
        private BookingRepository $bookings = new BookingRepository(),
        private NotificationService $notifications = new NotificationService()
    ) {}

    public function all(): array
    {
        return $this->bookings->detailed();
    }

    public function mine(string $userId): array
    {
        return $this->bookings->detailed('b.user_id = ?', [$userId]);
    }

    public function find(string $id): ?array
    {
        return $this->bookings->findDetailed($id);
    }

    public function create(string $userId, array $data): array
    {
        $conflict = $this->hasConflict($data['room_id'], $data['time_slot_id'], $data['booking_date']);
        if ($conflict) {
            return ['ok' => false, 'message' => 'Phòng đã có lịch hoặc booking trong khung giờ này.'];
        }
        $id = $this->bookings->create([
            'user_id' => $userId,
            'room_id' => $data['room_id'],
            'time_slot_id' => $data['time_slot_id'],
            'booking_date' => $data['booking_date'],
            'status' => 'pending',
            'note' => $data['note'] ?? '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        return ['ok' => true, 'id' => $id];
    }

    public function update(string $id, array $data): array
    {
        $booking = $this->bookings->find($id);
        if (!$booking || $booking['status'] !== 'pending') {
            return ['ok' => false, 'message' => 'Chỉ sửa được booking đang chờ duyệt.'];
        }
        $conflict = $this->hasConflict($data['room_id'], $data['time_slot_id'], $data['booking_date'], $id);
        if ($conflict) {
            return ['ok' => false, 'message' => 'Phòng đã bận trong khung giờ này.'];
        }
        $this->bookings->update($id, [
            'room_id' => $data['room_id'],
            'time_slot_id' => $data['time_slot_id'],
            'booking_date' => $data['booking_date'],
            'note' => $data['note'] ?? '',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        return ['ok' => true];
    }

    public function approve(string $id, string $adminId): void
    {
        Database::transaction(function () use ($id, $adminId) {
            $booking = $this->bookings->find($id);
            $this->bookings->update($id, [
                'status' => 'approved',
                'approved_by' => $adminId,
                'approved_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            if ($booking) {
                $this->notifications->create([
                    'user_id' => $booking['user_id'],
                    'title' => 'Booking đã được duyệt',
                    'message' => 'Yêu cầu đặt phòng ngày ' . $booking['booking_date'] . ' đã được duyệt.',
                    'type' => 'booking_approved',
                    'related_type' => 'booking',
                    'related_id' => $id,
                ]);
            }
        });
    }

    public function reject(string $id, string $adminId, string $reason): void
    {
        Database::transaction(function () use ($id, $adminId, $reason) {
            $booking = $this->bookings->find($id);
            $this->bookings->update($id, [
                'status' => 'rejected',
                'rejection_reason' => $reason,
                'approved_by' => $adminId,
                'approved_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            if ($booking) {
                $this->notifications->create([
                    'user_id' => $booking['user_id'],
                    'title' => 'Booking bị từ chối',
                    'message' => $reason ?: 'Yêu cầu đặt phòng của bạn chưa được chấp nhận.',
                    'type' => 'booking_rejected',
                    'related_type' => 'booking',
                    'related_id' => $id,
                ]);
            }
        });
    }

    public function cancel(string $id, string $userId): void
    {
        Database::statement("UPDATE bookings SET status = 'cancelled', updated_at = ? WHERE booking_id = ? AND user_id = ? AND status = 'pending'", [date('Y-m-d H:i:s'), $id, $userId]);
    }

    private function hasConflict(string $roomId, string $timeSlotId, string $date, ?string $ignoreBookingId = null): bool
    {
        $params = [$roomId, $timeSlotId, $date];
        $ignore = '';
        if ($ignoreBookingId) {
            $ignore = 'AND booking_id <> ?';
            $params[] = $ignoreBookingId;
        }
        $booking = Database::first("SELECT booking_id FROM bookings WHERE room_id = ? AND time_slot_id = ? AND booking_date = ? AND status IN ('pending','approved') {$ignore}", $params);
        $schedule = Database::first('SELECT class_schedule_id FROM class_schedules WHERE room_id = ? AND time_slot_id = ? AND ? BETWEEN start_date AND end_date', [$roomId, $timeSlotId, $date]);
        return (bool)($booking || $schedule);
    }
}
