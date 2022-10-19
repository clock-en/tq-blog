<?php
namespace App\Domain\ValueObject;

use Exception;
use DateTime;

final class JaDateTime
{
    const INVALID_MESSAGE = '日時の形式が正しくありません。';
    const DEFAULT_FORMAT = 'YYYY-MM-DD HH:MI:SS';

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
        return $this->isInvalidFormat($value);
    }

    /**
     * 日時形式チェック
     * @param string $value
     * @return bool
     */
    private function isInvalidFormat(string $value): bool
    {
      $timeObj = DateTime::createFromFormat(self::DEFAULT_FORMAT, $value);
      return $timeObj && $timeObj->format(self::DEFAULT_FORMAT) === $value;
    }
}
