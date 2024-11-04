<?php

class OrderManager
{
    private PDO $connection;
    private string $table = 'orders';

    public function __construct()
    {
        $this->connection = Db::query();
    }

    public static function model(): static
    {
        return new static();
    }

    public function userOrdersWithProducts(int $user_id, int $status): array
    {
        $query = $this->connection->prepare(
            'SELECT ' . $this->table . '.*, order_products.*
             FROM ' . $this->table . '
             LEFT JOIN order_products ON ' . $this->table . '.id = order_products.order_id
             WHERE ' . $this->table . '.user_id = :user_id AND ' . $this->table . '.status != :status'
        );

        $query->execute(['user_id' => $user_id, 'status' => $status]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function userCardWithProducts(int $user_id, int $status): array
    {
        $query = $this->connection->prepare(
            'SELECT ' . $this->table . '.*, order_products.*
             FROM ' . $this->table . '
             LEFT JOIN order_products ON ' . $this->table . '.id = order_products.order_id
             WHERE ' . $this->table . '.user_id = :user_id AND ' . $this->table . '.status = :status'
        );

        $query->execute(['user_id' => $user_id, 'status' => $status]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function userCard(int $user_id, int $status): object|false
    {
        $query = $this->connection->prepare(
            'SELECT * FROM ' . $this->table .
            ' WHERE ' . $this->table . '.user_id = :user_id AND ' . $this->table . '.status = :status'
        );

        $query->execute(['user_id' => $user_id, 'status' => $status]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function create(array $data): false|string
    {
        $stmt = $this->connection->prepare(
            'INSERT INTO ' . $this->table . ' (user_id, status) VALUES (:user_id, :status)'
        );
        $stmt->execute([
            'user_id' => $data['user_id'],
            'status' => $data['status'],
        ]);
        return $this->connection->lastInsertId();
    }

    public static function query(): ?PDO
    {
        return Db::query();
    }
}
