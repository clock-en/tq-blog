<?php
namespace App\Domain\ValueObject;

use Exception;

final class Order
{
    const ORDER_REG_EXP = "/^(asc|desc)$/";
    const INVALID_MESSAGE = '不正な値です';

    /** @var string */
    private string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        if ($this->isInvalid($value)) {
            throw new Exception(self::INVALID_MESSAGE);
        }
        $this->value = $value;
    }

    /**
     * Value値を取得
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * Value値のバリデーション
     * @param string $value
     * @return bool
     */
    private function isInvalid(string $value): bool
    {
        return !preg_match(self::ORDER_REG_EXP, $value);
    }
}
