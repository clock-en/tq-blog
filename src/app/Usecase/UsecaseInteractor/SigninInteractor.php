<?php
namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\SigninInput;
use App\UseCase\UseCaseOutput\SigninOutput;
use App\Infrastructure\Dao\LoginSessionDao;
use App\Infrastructure\Dao\UserSqlDao;

final class SigninInteractor
{
    const FAILED_MESSAGE = 'メールアドレスまたはパスワードが違います。';
    const COMPLETE_MESSAGE = 'ログインしました。';

    private $userDao;
    private $input;

    public function __construct(SigninInput $input)
    {
        $this->userDao = new UserSqlDao();
        $this->input = $input;
    }

    public function handle(): SigninOutput
    {
        $user = $this->findUser();
        if (is_null($user) || $this->isInvalidPassword($user['password'])) {
            return new SigninOutput(false, self::FAILED_MESSAGE);
        }
        $loginDao = new LoginSessionDao();
        $loginDao->setLoginUser($user['id'], $user['name']);
        return new SigninOutput(true, self::COMPLETE_MESSAGE);
    }

    private function findUser(): ?array
    {
        return $this->userDao->findByMail($this->input->getEmail());
    }

    private function isInvalidPassword(string $password): bool
    {
        return !password_verify($this->input->getPassword(), $password);
    }
}
