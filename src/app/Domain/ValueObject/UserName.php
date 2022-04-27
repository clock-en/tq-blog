<?php
namespace App\Domain\ValueObject;

use Exception;

final class UserName
{
    const INVALID_MESSAGE = 'お名前は20文字以内でご入力ください。';

    private $value;

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
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Value値のバリデーション
     * @param string $value
     * @return bool
     */
    private function isInvalid($value)
    {
        return mb_strlen($value) > 20;
    }
}
