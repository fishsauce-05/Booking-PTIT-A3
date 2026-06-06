<?php

namespace App\Repositories;

use App\Core\Database;

class NotificationRepository extends BaseRepository
{
    protected string $table = 'notifications';
    protected string $primaryKey = 'notification_id';
    protected array $fillable = ['user_id', 'title', 'message', 'type', 'related_type', 'related_id', 'is_read', 'created_at', 'read_at'];

    public function forUser(string $userId): array
    {
        return Database::select('SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC', [$userId]);
    }

    public function unreadCount(string $userId): int
    {
        return (int)(Database::first('SELECT COUNT(*) as count FROM notifications WHERE user_id = ? AND is_read = 0', [$userId])['count'] ?? 0);
    }
}
