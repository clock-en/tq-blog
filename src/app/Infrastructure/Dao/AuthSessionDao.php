<?php
namespace App\Infrastructure\Dao;

final class AuthSessionDao
{
    const SESSION_NAME = 'auth';
    public function getSigninUser(): ?array
    {
        if (isset($_SESSION[self::SESSION_NAME])) {
            return $_SESSION[self::SESSION_NAME];
        }
        return null;
    }
    public function setSigninUser(string $id, string $name): void
    {
        $_SESSION[self::SESSION_NAME] = ['id' => $id, 'name' => $name];
    }
}
