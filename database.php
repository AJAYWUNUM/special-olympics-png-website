<?php
declare(strict_types=1);

function site_database(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $config = require __DIR__ . '/database-config.php';
    foreach (['host', 'database', 'username', 'password'] as $key) {
        $value = trim((string) ($config[$key] ?? ''));
        if ($value === '' || str_starts_with($value, 'YOUR_') || str_starts_with($value, 'SET_')) {
            throw new RuntimeException('Website database settings are incomplete.');
        }
    }

    $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['database'] . ';charset=utf8mb4';
    $pdo = new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    return $pdo;
}

