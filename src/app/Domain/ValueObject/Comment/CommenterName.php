<?php
namespace App\Domain\ValueObject\Comment;

use Exception;

final class CommenterName
{
    const MAX_LENGTH = 50;
    const INVALID_MESSAGE = 'タイトルは50文字以内でご入力ください';

    /** @var string */
    private string $value;

    /**
     * @param string
     */
    public function __construct(string $value)
    {
        if ($this->isInvalid($value)) {
            throw new Exception(self::INVALID_MESSAGE);
        }
        $this->value = $value;
    }

    /**
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
        return mb_strlen($value) > self::MAX_LENGTH;
    }
}
