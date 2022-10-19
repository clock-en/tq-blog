<?php
namespace App\Domain\ValueObject\Article;

use Exception;

final class ArticleTitle
{
    const MAX_LENGTH = 255;
    const INVALID_MESSAGE = 'タイトルは255文字以内でご入力ください';

    private string $value;

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
