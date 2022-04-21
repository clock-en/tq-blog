<?php
namespace App\UseCase\UseCaseOutput;

final class SigninOutput
{
    private $isSuccess;
    private $message;

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
     * インタラクトメッセージの取得
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
