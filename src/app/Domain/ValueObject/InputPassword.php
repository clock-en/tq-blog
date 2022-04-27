<?php
namespace App\Domain\ValueObject;

use Exception;

final class InputPassword
{
    /**
     * パスワードの書式
     * 半角英数字両方を含む、8文字以上の文字列
     */
    const PASSWORD_REG_EXP = '/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i';
    const INVALID_MESSAGE = 'パスワードの形式が正しくありません。';

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
    public function value(): string
    {
        return $this->value;
    }

    /**
     * パスワードをハッシュ化
     * @return HashedPassword
     */
    public function hash(): HashedPassword
    {
        return new HashedPassword($this);
    }

    /**
     * Value値のバリデーション
     * @param string $value
     * @return bool
     */
    private function isInvalid(string $value): bool
    {
        return !preg_match(self::PASSWORD_REG_EXP, $value);
    }
}
