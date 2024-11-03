<?php

class UserManager
{
    private static string $table = 'users';
    public static function query(): ?PDO
    {
        return Db::query();
    }
}