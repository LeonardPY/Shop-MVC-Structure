<?php

class OrderProductManager
{
    private PDO $connection;
    private string $table = 'order_products';

    public function __construct()
    {
        $this->connection = Db::query();
    }

    public static function model(): static
    {
        return new static();
    }

    public function create(array $data): void
    {
        $stmt = $this->connection->prepare(
            'INSERT INTO ' . $this->table . ' (order_id, product_id, product_price, product_count) 
            VALUES (:order_id, :product_id, :product_price, :product_count)'
        );
        $stmt->execute([
            'order_id' => $data['order_id'],
            'product_id' => $data['product_id'],
            'product_price' => $data['product_price'],
            'product_count' => $data['product_count'],
        ]);
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->connection->prepare(
            'UPDATE ' . $this->table . '
        SET product_price = :product_price, product_count = :product_count
        WHERE id = :id'
        );

        $stmt->execute([
            'product_price' => $data['product_price'],
            'product_count' => $data['product_count'],
            'id' => $id,
        ]);
    }


    public function getProductInCardByOrderIdCardId(int $orderId, int $productId): object|false
    {
        $query = $this->connection->prepare(
            'SELECT * FROM ' . $this->table . ' WHERE order_id = :order_id AND product_id = :product_id'
        );
        $query->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $query->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_CLASS, get_class((object)self::class));
        return $query->fetch();
    }

    public function deleteProductInCardByOrderIdCardId(int $orderId, int $productId): bool
    {
        $query = $this->connection->prepare(
            'DELETE FROM ' . $this->table . ' WHERE order_id = :order_id AND product_id = :product_id'
        );
        $query->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $query->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $query->execute();

        return $query->rowCount() > 0;
    }

    public static function query(): ?PDO
    {
        return Db::query();
    }
}
