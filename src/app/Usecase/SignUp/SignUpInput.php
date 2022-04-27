<?php
namespace App\UseCase\SignUp;

use App\Domain\ValueObject\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\InputPassword;

final class SignUpInput
{
    private UserName $name;
    private Email $email;
    private InputPassword $password;

    public function __construct(
        UserName $name,
        Email $email,
        InputPassword $password
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * name入力を取得
     * @return UserName
     */
    public function name(): UserName
    {
        return $this->name;
    }

    /**
     * email入力を取得
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * password入力を取得
     * @return InputPassword
     */
    public function password(): InputPassword
    {
        return $this->password;
    }
}
