<?php

namespace App\Services;

use App\Core\Database;
use App\Repositories\UserRepository;

class UserService
{
    public function __construct(private UserRepository $users = new UserRepository()) {}

    public function all(): array
    {
        return $this->users->all('created_at DESC');
    }

    public function find(string $id): ?array
    {
        return $this->users->withLecturer($id);
    }

    public function create(array $data): string
    {
        return Database::transaction(function () use ($data) {
            $id = $this->users->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password_hash' => password_hash($data['password'] ?: 'password', PASSWORD_DEFAULT),
                'role' => $data['role'],
                'is_active' => isset($data['is_active']) ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            if ($data['role'] === 'lecturer') {
                Database::statement(
                    'INSERT INTO lecturers (lecturer_id, user_id, lecturer_code, department, level) VALUES (?, ?, ?, ?, ?)',
                    [uniqid('lecturer_', true), $id, $data['lecturer_code'] ?: strtoupper(substr($id, -6)), $data['department'] ?: 'Công nghệ thông tin', $data['level'] ?? 'normal']
                );
            }
            return $id;
        });
    }

    public function update(string $id, array $data): void
    {
        Database::transaction(function () use ($id, $data) {
            $existing = $this->find($id);
            $payload = [
                'name' => array_key_exists('name', $data) ? trim($data['name']) : ($existing['name'] ?? ''),
                'email' => trim($data['email']),
                'role' => $data['role'],
                'is_active' => isset($data['is_active']) ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            if (!empty($data['password'])) {
                $payload['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }
            $this->users->update($id, $payload);

            if ($data['role'] === 'lecturer') {
                $lecturerCode = trim($data['lecturer_code'] ?? '') ?: ($existing['lecturer_code'] ?? strtoupper(substr($id, -6)));
                $department = trim($data['department'] ?? '') ?: ($existing['department'] ?? 'Công nghệ thông tin');
                $level = $existing['level'] ?? ($data['level'] ?? 'normal');

                if (!empty($existing['lecturer_code'])) {
                    Database::statement(
                        'UPDATE lecturers SET lecturer_code = ?, department = ?, level = ? WHERE user_id = ?',
                        [$lecturerCode, $department, $level, $id]
                    );
                } else {
                    Database::statement(
                        'INSERT INTO lecturers (lecturer_id, user_id, lecturer_code, department, level) VALUES (?, ?, ?, ?, ?)',
                        [uniqid('lecturer_', true), $id, $lecturerCode, $department, $level]
                    );
                }
            } else {
                Database::statement('DELETE FROM lecturers WHERE user_id = ?', [$id]);
            }
        });
    }

    public function changePassword(string $id, string $password): void
    {
        $this->users->update($id, ['password_hash' => password_hash($password, PASSWORD_DEFAULT), 'updated_at' => date('Y-m-d H:i:s')]);
    }
}
