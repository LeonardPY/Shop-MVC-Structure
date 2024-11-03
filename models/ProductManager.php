<?php

class ProductManager
{
    private static string $table = 'products';
    public function getProducts(array $params): ?array
    {
        return Db::queryAll('SELECT  * FROM ' . static::$table, $params);
    }


    public function find($id): ?object
    {
        $stmt = self::query()->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject(self::class);
    }

    public function create(array $data): void
    {
        $stmt = self::query()->prepare('INSERT INTO products (name, description, price, image) VALUES (:name, :description, :price, :image)');
        $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'image' => $data['image'],
        ]);
    }

    public function update(int $id, array $data): void
    {
        $stmt = self::query()->prepare(
            'UPDATE products SET name = :name, description = :description, price = :price, image = :image WHERE id = :id'
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
        $stmt = self::query()->prepare('DELETE FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public static function query(): ?PDO
    {
        return Db::query();
    }
}