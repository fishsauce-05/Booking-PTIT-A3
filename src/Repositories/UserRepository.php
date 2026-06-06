<?php

namespace App\Repositories;

use App\Core\Database;

class UserRepository extends BaseRepository {
    protected string $table = 'users';
    protected string $primaryKey = 'user_id';
    protected array $fillable = ['name', 'email', 'password_hash', 'role', 'is_active', 'created_at', 'updated_at'];

    public function findByEmail(string $email): ?array {
        return Database::first('SELECT * FROM users WHERE email = ?', [$email]);
    }

    public function withLecturer(string $id): ?array {
        return Database::first('SELECT users.*, lecturers.lecturer_code, lecturers.department, lecturers.level FROM users LEFT JOIN lecturers ON lecturers.user_id = users.user_id WHERE users.user_id = ?', [$id]);
    }
}
