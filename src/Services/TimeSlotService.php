<?php

namespace App\Services;

use App\Repositories\TimeSlotRepository;

class TimeSlotService
{
    public function __construct(private TimeSlotRepository $repo = new TimeSlotRepository()) {}
    public function all(): array { return $this->repo->all('start_time'); }
    public function find(string $id): ?array { return $this->repo->find($id); }
    public function save(array $data, ?string $id = null): string
    {
        $payload = ['slot_name' => $data['slot_name'], 'start_time' => $data['start_time'], 'end_time' => $data['end_time']];
        if ($id) { $this->repo->update($id, $payload); return $id; }
        return $this->repo->create($payload);
    }
    public function delete(string $id): void { $this->repo->delete($id); }
}
