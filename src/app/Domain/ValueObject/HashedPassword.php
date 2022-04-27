<?php
namespace App\Domain\ValueObject;

final class HashedPassword
{
    private $value;

    public function __construct(InputPassword $inputPassword)
    {
        $this->value = password_hash($inputPassword->value(), PASSWORD_DEFAULT);
    }

    /**
     * Value値を取得
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }
}
