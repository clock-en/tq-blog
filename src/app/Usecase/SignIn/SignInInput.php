<?php
namespace App\UseCase\SignIn;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\InputPassword;

final class SignInInput
{
    private Email $email;
    private InputPassword $password;

    public function __construct(Email $email, InputPassword $password)
    {
        $this->email = $email;
        $this->password = $password;
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
