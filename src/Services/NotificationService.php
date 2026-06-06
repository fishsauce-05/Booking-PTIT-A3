<?php

namespace App\Services;

use App\Repositories\NotificationRepository;

class NotificationService
{
    public function __construct(private NotificationRepository $repo = new NotificationRepository()) {}
    public function forUser(string $userId): array { return $this->repo->forUser($userId); }
    public function all(): array { return $this->repo->all('created_at DESC'); }
    public function unreadCount(string $userId): int { return $this->repo->unreadCount($userId); }
    public function create(array $data): string
    {
        return $this->repo->create($data + ['is_read' => 0, 'created_at' => date('Y-m-d H:i:s')]);
    }
    public function markRead(string $id): void
    {
        $this->repo->update($id, ['is_read' => 1, 'read_at' => date('Y-m-d H:i:s')]);
    }
}
