<?php
namespace App\UseCase\SignUp;

use App\Infrastructure\Dao\UserSqlDao;

final class SignUpInteractor
{
    const ALREADY_EXIST_MESSAGE = '入力したメールアドレスは既に入力済みです。';
    const COMPLETE_MESSAGE = '登録が完了しました。';

    private $userDao;
    private $input;

    public function __construct(SignUpInput $input)
    {
        $this->userDao = new UserSqlDao();
        $this->input = $input;
    }

    /**
     * インタラクタ実行
     * @return SignUpOutput
     */
    public function handle(): SignUpOutput
    {
        $user = $this->findUser();
        if (!is_null($user)) {
            return new SignUpOutput(false, self::ALREADY_EXIST_MESSAGE);
        }
        $this->createUser();
        return new SignUpOutput(true, self::COMPLETE_MESSAGE);
    }

    /**
     * ユーザー取得
     * @return array | null
     */
    private function findUser(): ?array
    {
        return $this->userDao->findByMail($this->input->getEmail()->getValue());
    }

    /**
     * ユーザー作成
     */
    private function createUser(): void
    {
        $name = $this->input->getName()->getValue();
        $email = $this->input->getEmail()->getValue();
        $password = $this->input->getPassword()->getValue();
        $this->userDao->create($name, $email, $password);
    }
}
