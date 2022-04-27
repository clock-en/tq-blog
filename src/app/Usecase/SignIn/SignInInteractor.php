<?php
namespace App\UseCase\SignIn;

use App\Infrastructure\Dao\UserSqlDao;
use App\Utils\Session;

final class SignInInteractor
{
    const FAILED_MESSAGE = 'メールアドレスまたはパスワードが違います。';
    const COMPLETE_MESSAGE = 'ログインしました。';

    private $userDao;
    private $input;

    public function __construct(SignInInput $input)
    {
        $this->userDao = new UserSqlDao();
        $this->input = $input;
    }

    /**
     * インタラクタ実行
     * @return SignInOutput
     */
    public function handle(): SignInOutput
    {
        $user = $this->findUser();

        if (is_null($user) || $this->isInvalidPassword($user['password'])) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        $this->saveSession($user);
        return new SignInOutput(true, self::COMPLETE_MESSAGE);
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
     * パスワード認証
     * @param string $password
     * @return bool
     */
    private function isInvalidPassword(string $password): bool
    {
        return !password_verify(
            $this->input->getPassword()->getValue(),
            $password
        );
    }

    /**
     * ログインユーザー情報をセッションに保存
     * @param array $user
     * @return bool
     */
    private function saveSession(array $user)
    {
        $session = Session::getInstance();
        $session->setUser($user['id'], $user['name']);
    }
}
