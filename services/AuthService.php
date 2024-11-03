<?php

class AuthService
{
    public function login(string $email, string $password): ?array
    {
        try {
            $stmt = UserManager::query()->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin && password_verify($password, $admin['password'])) {
                if ($admin['role'] === UserRoleEnum::ADMIN->value) {
                    $_SESSION['admin'] = [
                        'id' => $admin['id'],
                        'name' => $admin['name'],
                    ];
                }
            }
        } catch (PDOException $e) {
            return null;
        }

        return $admin;
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        unset($_SESSION['admin']);
    }
}