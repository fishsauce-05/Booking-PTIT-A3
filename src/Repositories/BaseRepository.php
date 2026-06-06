<?php

namespace App\Repositories;

use App\Core\Database;

abstract class BaseRepository {
    protected string $table;
    protected string $primaryKey;
    protected array $fillable = [];

    public function all(string $orderBy = ''): array
    {
        $order = $orderBy ?: $this->primaryKey . ' DESC';
        return Database::select("SELECT * FROM {$this->table} ORDER BY {$order}");
    }

    public function paginate(int $page = 1, int $perPage = 10, string $where = '1=1', array $params = [], string $orderBy = ''): array
    {
        $offset = max(0, ($page - 1) * $perPage);
        $order = $orderBy ?: $this->primaryKey . ' DESC';
        $total = Database::first("SELECT COUNT(*) as count FROM {$this->table} WHERE {$where}", $params)['count'] ?? 0;
        $items = Database::select("SELECT * FROM {$this->table} WHERE {$where} ORDER BY {$order} LIMIT {$perPage} OFFSET {$offset}", $params);
        return [
            'items' => $items,
            'page' => $page,
            'perPage' => $perPage,
            'total' => (int)$total,
            'pages' => max(1, (int)ceil($total / $perPage)),
        ];
    }

    public function find(string $id): ?array
    {
        return Database::first("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?", [$id]);
    }

    public function create(array $data): string
    {
        $id = $data[$this->primaryKey] ?? $this->newId();
        $data[$this->primaryKey] = $id;
        $data = $this->filter($data);
        $columns = array_keys($data);
        $placeholders = implode(',', array_fill(0, count($columns), '?'));
        Database::statement(
            "INSERT INTO {$this->table} (" . implode(',', $columns) . ") VALUES ({$placeholders})",
            array_values($data)
        );
        return $id;
    }

    public function update(string $id, array $data): bool
    {
        $data = $this->filter($data);
        unset($data[$this->primaryKey]);
        if (!$data) {
            return true;
        }
        $sets = implode(',', array_map(fn($key) => "{$key} = ?", array_keys($data)));
        $params = array_values($data);
        $params[] = $id;
        return Database::statement("UPDATE {$this->table} SET {$sets} WHERE {$this->primaryKey} = ?", $params);
    }

    public function delete(string $id): bool
    {
        return Database::statement("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?", [$id]);
    }

    protected function filter(array $data): array
    {
        $allowed = array_merge([$this->primaryKey], $this->fillable);
        return array_intersect_key($data, array_flip($allowed));
    }

    protected function newId(): string
    {
        return uniqid(str_replace('_', '', $this->table) . '_', true);
    }
}
