<?php
namespace App\UseCase\UseCaseInput;

final class SigninInput
{
    private $email;
    private $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * email入力を取得
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * password入力を取得
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
