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

    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
