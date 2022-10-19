<?php
namespace App\Domain\ValueObject;

final class HashedPassword
{
    private string $value;

    public function __construct(string $value)
    {
        // TODO: ハッシュ化された文字列かどうかを判別する方法が見つかったら実装
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
     * パスワードの照合関数
     * @param InputPassword
     * @return bool
     */
    public function verify(InputPassword $password): bool
    {
        return password_verify($password->value(), $this->value);
    }
}
