<?php
namespace App\UseCase\SignUp;

use App\Adapter\QueryService\UserQueryService;
use App\Adapter\Repository\UserRepository;
use App\Domain\Entity\User;
use App\Domain\ValueObject\User\NewUser;

final class SignUpInteractor
{
    const ALREADY_EXIST_MESSAGE = '入力したメールアドレスは既に入力済みです。';
    const COMPLETE_MESSAGE = '登録が完了しました。';

    private SignUpInput $input;
    private UserQueryService $userQueryService;
    private UserRepository $userRepository;

    public function __construct(SignUpInput $input)
    {
        $this->input = $input;
        $this->userQueryService = new UserQueryService();
        $this->userRepository = new UserRepository();
    }

    /**
     * インタラクタ実行
     * @return SignUpOutput
     */
    public function handle(): SignUpOutput
    {
        $user = $this->findUser();
        if ($this->existsUser($user)) {
            return new SignUpOutput(false, self::ALREADY_EXIST_MESSAGE);
        }
        $this->signUp();
        return new SignUpOutput(true, self::COMPLETE_MESSAGE);
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
     * ユーザー作成
     */
    private function signUp(): void
    {
        $this->userRepository->create(
            new NewUser(
                $this->input->name(),
                $this->input->email(),
                $this->input->password()
            )
        );
    }
}
