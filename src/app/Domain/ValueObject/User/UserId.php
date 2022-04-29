<?php
namespace App\Domain\ValueObject\User;

use Exception;

final class UserId
{
    const MIN_VALUE = 1;
    const INVALID_MESSAGE = '不正な値です。';

    private int $value;

    public function __construct(int $value)
    {
        if ($this->isInvalid($value)) {
            throw new Exception(self::INVALID_MESSAGE);
        }
        $this->value = $value;
    }

    /**
     * Value値を取得
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * Value値のバリデーション
     * @param int $value
     * @return bool
     */
    private function isInvalid(int $value): bool
    {
        return $value < self::MIN_VALUE;
    }
}
