<?php

class Db
{
    private static array $settings = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    private static ?PDO $connection = null;

    public static function connect(string $host, string $user, string $password, string $database): void
    {
        if (!isset(self::$connection)) {
            try {
                self::$connection = new PDO(
                    "mysql:host=$host;dbname=$database",
                    $user,
                    $password,
                    self::$settings
                );
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
    }

    public static function queryOne(string $query, array $params = []): ?array
    {
        $result = self::$connection->prepare($query);
        $result->execute($params);
        return $result->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function queryAll(string $query, array $params = []): array
    {
        $result = self::$connection->prepare($query);
        $result->execute($params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function querySingle(string $query, array $params = []): ?array
    {
        $result = self::queryOne($query, $params);
        return $result ? $result[0] : null;
    }

    public static function query(): ?PDO
    {
        return self::$connection;
    }
}
