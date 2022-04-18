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
    public function setLoginUser(string $id, string $name): void
    {
        $_SESSION[self::SESSION_NAME] = ['id' => $id, 'name' => $name];
    }
}
