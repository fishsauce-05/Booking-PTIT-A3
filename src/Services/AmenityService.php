<?php

namespace App\Services;

use App\Repositories\AmenityRepository;

class AmenityService
{
    public function __construct(private AmenityRepository $repo = new AmenityRepository()) {}
    public function all(): array { return $this->repo->all('name'); }
    public function find(string $id): ?array { return $this->repo->find($id); }
    public function save(array $data, ?string $id = null): string
    {
        $payload = ['name' => $data['name'], 'description' => $data['description'] ?? ''];
        if ($id) { $this->repo->update($id, $payload); return $id; }
        return $this->repo->create($payload);
    }
    public function delete(string $id): void { $this->repo->delete($id); }
}
