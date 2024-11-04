<?php

class ProductManager
{
    private PDO $connection;
    private string $table = 'products';

    public function __construct()
    {
        $this->connection = Db::query();
    }

    public static function model(): static
    {
        return new static();
    }

    public function getProducts(array $params): ?array
    {
        return Db::queryAll('SELECT * FROM ' . $this->table, $params);
    }

    public function find(int $id): mixed
    {
        $stmt = $this->connection->prepare('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject(self::class);
    }

    public function create(array $data): void
    {
        $stmt = $this->connection->prepare(
            'INSERT INTO ' . $this->table . ' (name, description, price, image) VALUES (:name, :description, :price, :image)'
        );
        $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'image' => $data['image'],
        ]);
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->connection->prepare(
            'UPDATE ' . $this->table .
            'SET name = :name, description = :description, price = :price, image = :image WHERE id = :id'
        );
        $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'image' => $data['image'],
            'id' => $id,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->connection->prepare('DELETE FROM ' . $this->table . ' WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public static function query(): ?PDO
    {
        return Db::query();
    }
}