<?php

class ProductManager
{
    private static string $table = 'products';
    public function getProducts(array $params): ?array
    {
        return Db::queryAll('SELECT  * FROM ' . static::$table, $params);
    }
}