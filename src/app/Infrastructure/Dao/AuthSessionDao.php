<?php
namespace App\Infrastructure\Dao;

final class AuthSessionDao
{
    const SESSION_NAME = 'auth';

    /**
     * Signinユーザーの情報を取得
     * @return array | null
     */
    public function getSigninUser(): ?array
    {
        if (isset($_SESSION[self::SESSION_NAME])) {
            return $_SESSION[self::SESSION_NAME];
        }
        return null;
    }

    /**
     * Signinユーザーの情報を設定
     * @param string $id
     * @param string $name
     */
    public function setSigninUser(string $id, string $name): void
    {
        $_SESSION[self::SESSION_NAME] = ['id' => $id, 'name' => $name];
    }
}
