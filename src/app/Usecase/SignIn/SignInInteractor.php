<?php
namespace App\UseCase\SignIn;

use App\Adapter\QueryService\UserQueryService;
use App\Domain\Entity\User;
use App\Domain\ValueObject\HashedPassword;
use App\Utils\Session;

final class SignInInteractor
{
    const FAILED_MESSAGE = 'メールアドレスまたはパスワードが違います。';
    const COMPLETE_MESSAGE = 'ログインしました。';

    private SignInInput $input;
    private UserQueryService $userQueryService;

    public function __construct(SignInInput $input)
    {
        $this->input = $input;
        $this->userQueryService = new UserQueryService();
    }

    /**
     * インタラクタ実行
     * @return SignInOutput
     */
    public function handle(): SignInOutput
    {
        $user = $this->findUser();

        if (!$this->existsUser($user)) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        if ($this->isInvalidPassword($user->password())) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        $this->saveSession($user);
        return new SignInOutput(true, self::COMPLETE_MESSAGE);
    }

    /**
     * ユーザー取得
     * @return User|null
     */
    private function findUser(): ?User
    {
        return $this->userQueryService->findByMail($this->input->email());
    }

    /**
     * ユーザーの存在チェック
     * @param User|null
     * @return bool
     */
    private function existsUser(?User $user)
    {
        return !is_null($user);
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
