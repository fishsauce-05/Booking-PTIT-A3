<?php

namespace App\Core;

use PDO;

class Database
{
    private static ?PDO $pdo = null;

    public static function boot(array $config): void
    {
        if (self::$pdo) {
            return;
        }

        $connection = $config['connection'] ?? 'sqlite';
        if ($connection === 'mysql') {
            $mysql = $config['mysql'];
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                $mysql['host'],
                $mysql['port'],
                $mysql['database'],
                $mysql['charset']
            );
            self::$pdo = new PDO($dsn, $mysql['username'], $mysql['password']);
        } else {
            $database = $config['sqlite']['database'];
            $dir = dirname($database);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            self::$pdo = new PDO('sqlite:' . $database);
            self::$pdo->exec('PRAGMA foreign_keys = ON');
        }

        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public static function pdo(): PDO {
        if (!self::$pdo) {
            self::boot(config('database'));
        }
        return self::$pdo;
    }

    public static function select(string $sql, array $params = []): array
    {
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function first(string $sql, array $params = []): ?array
    {
        $rows = self::select($sql, $params);
        return $rows[0] ?? null;
    }

    public static function statement(string $sql, array $params = []): bool
    {
        $stmt = self::pdo()->prepare($sql);
        return $stmt->execute($params);
    }

    public static function transaction(callable $callback): mixed
    {
        $pdo = self::pdo();
        $pdo->beginTransaction();
        try {
            $result = $callback();
            $pdo->commit();
            return $result;
        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}
