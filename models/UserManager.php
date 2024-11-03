<?php

class UserManager
{
    private static string $table = 'products';
    public static function query(): ?PDO
    {
        return Db::query();
    }
}