<?php
namespace App\UseCase\SignIn;

use App\Domain\Entity\User;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\HashedPassword;
use App\Infrastructure\Dao\UserSqlDao;
use App\Utils\Session;

final class SignInInteractor
{
    const FAILED_MESSAGE = 'メールアドレスまたはパスワードが違います。';
    const COMPLETE_MESSAGE = 'ログインしました。';

    private UserSqlDao $userDao;
    private SignInInput $input;

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
        $userMapper = $this->findUser();

        if (is_null($userMapper)) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        $user = $this->buildUserEntity($userMapper);

        if ($this->isInvalidPassword($user->password())) {
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
        return $this->userDao->findByMail($this->input->email()->value());
    }

    /**
     * Userエンティティを生成
     * @return User
     */
    private function buildUserEntity(array $userMapper): User
    {
        return new User(
            new UserId($userMapper['id']),
            new UserName($userMapper['name']),
            new Email($userMapper['email']),
            new HashedPassword($userMapper['password'])
        );
    }

    /**
     * パスワード認証
     * @param HashedPassword $password
     * @return bool
     */
    private function isInvalidPassword(HashedPassword $password): bool
    {
        return !$password->verify($this->input->password());
    }

    /**
     * ログインユーザー情報をセッションに保存
     * @param User $user
     */
    private function saveSession(User $user): void
    {
        $session = Session::getInstance();
        $session->setUser($user->id()->value(), $user->name()->value());
    }
}
