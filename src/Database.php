<?php
declare(strict_types=1);

class Database
{
    private PDO $connection;

    public function __construct(string $host, int $port, string $name, string $user, string $password)
    {
        $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4', $host, $port, $name);
        $this->connection = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
