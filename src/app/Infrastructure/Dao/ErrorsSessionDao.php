<?php
namespace App\Infrastructure\Dao;

final class ErrorsSessionDao
{
    const SESSION_NAME = 'errors';

    private $errors;

    public function __construct()
    {
        $this->errors = $_SESSION[self::SESSION_NAME] ?? [];
        unset($_SESSION[self::SESSION_NAME]);
    }

    /**
     * 入力エラーの取得
     * @return array | null
     */
    public function getErrors(): ?array
    {
        if (!empty($this->errors)) {
            return $this->errors;
        }
        return null;
    }

    /**
     * 入力エラーの設定
     * @param array $errors
     */
    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
        $_SESSION[self::SESSION_NAME] = $errors;
    }
}
