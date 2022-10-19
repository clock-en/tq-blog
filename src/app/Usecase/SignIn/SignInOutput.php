<?php
namespace App\UseCase\SignIn;

final class SignInOutput
{
    private bool $isSuccess;
    private string $message;

    public function __construct(bool $isSuccess, string $message)
    {
        $this->isSuccess = $isSuccess;
        $this->message = $message;
    }

    /**
     * インタラクト結果の取得
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    /**
     * フラッシュメッセージの取得
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }
}
