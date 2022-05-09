<?php
namespace App\Adapter\Repository;

use App\Infrastructure\Dao\UserSqlDao;
use App\Domain\ValueObject\User\NewUser;

final class UserRepository
{
    private UserSqlDao $userDao;

    public function __construct()
    {
        $this->userDao = new UserSqlDao();
    }

    /**
     * 新規ユーザーの作成
     * @param NewUser $user
     */
    public function create(NewUser $user): void
    {
        $this->userDao->create($user);
    }
}
