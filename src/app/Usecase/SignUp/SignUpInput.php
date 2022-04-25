<?php
namespace App\UseCase\SignUp;

final class SignUpInput
{
    private $name;
    private $email;
    private $password;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * name入力を取得
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
