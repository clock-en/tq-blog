<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\HashedPassword;

final class User
{
    private UserId $id;
    private UserName $name;
    private Email $email;
    private HashedPassword $password;

    public function __construct(
        UserId $id,
        UserName $name,
        Email $email,
        HashedPassword $password
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * ユーザーIDを取得
     * @return UserId
     */
    public function id(): UserId
    {
        return $this->id;
    }

    /**
     * ユーザー名を取得
     * @return UserName
     */
    public function name(): UserName
    {
        return $this->name;
    }

    /**
     * ユーザーのメールアドレスを取得
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * ユーザーのパスワードを取得
     * @return HashedPassword
     */
    public function password(): HashedPassword
    {
        return $this->password;
    }
}
