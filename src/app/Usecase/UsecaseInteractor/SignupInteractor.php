<?php
namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\SignupInput;
use App\UseCase\UseCaseOutput\SignupOutput;
use App\Infrastructure\Dao\UserSqlDao;

final class SignupInteractor
{
    const ALREADY_EXIST_MESSAGE = '入力したメールアドレスは既に入力済みです。';
    const COMPLETE_MESSAGE = '登録が完了しました。';

    private $userDao;
    private $input;

    public function __construct(SignupInput $input)
    {
        $this->userDao = new UserSqlDao();
        $this->input = $input;
    }

    public function handle(): SignupOutput
    {
        $user = $this->findUser();
        if (!is_null($user)) {
            return new SignupOutput(false, self::ALREADY_EXIST_MESSAGE);
        }
        $this->createUser();
        return new SignupOutput(true, self::COMPLETE_MESSAGE);
    }

    private function findUser(): ?array
    {
        return $this->userDao->findByMail($this->input->getEmail());
    }

    private function createUser(): void
    {
        $name = $this->input->getName();
        $email = $this->input->getEmail();
        $password = $this->input->getPassword();
        $this->userDao->create($name, $email, $password);
    }
}
