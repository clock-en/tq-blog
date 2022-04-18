<?php
namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\SignupInput;
use App\UseCase\UseCaseOutput\SignupOutput;
use App\Infrastructure\Dao\UserSqlDao;

final class SignupInteractor
{
    const ALREADY_EXIST_MESSAGE = '入力したメールアドレスは既に入力済みです。';
    const COMPLETE_MESSAGE = '登録が完了しました。';

    private $useCaseInput;

    public function __construct(SignupInput $useCaseInput)
    {
        $this->useCaseInput = $useCaseInput;
    }

    public function handle(): SignupOutput
    {
        $userDAO = new UserSqlDao();
        $name = $this->useCaseInput->getName();
        $email = $this->useCaseInput->getEmail();
        $password = $this->useCaseInput->getPassword();

        $user = $userDAO->findByMail($email);
        if (!is_null($user)) {
            return new SignupOutput(false, self::ALREADY_EXIST_MESSAGE);
        }
        $userDAO->create($name, $email, $password);
        return new SignupOutput(true, self::COMPLETE_MESSAGE);
    }
}
