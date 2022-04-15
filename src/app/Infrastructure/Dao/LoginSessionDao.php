<?php
namespace App\Infrastructure\Dao;

final class LoginSessionDao
{
    const SESSION_NAME = 'login';
    public function getLoginUser(): ?array
    {
        if (isset($_SESSION[self::SESSION_NAME])) {
            return $_SESSION[self::SESSION_NAME];
        }
        return null;
    }
    public function setLoginUser(string $name, string $email): void
    {
        $_SESSION[self::SESSION_NAME] = ['name' => $name, 'email' => $email];
    }
}
