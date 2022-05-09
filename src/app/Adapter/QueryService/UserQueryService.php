<?php
namespace App\Adapter\QueryService;

use App\Infrastructure\Dao\UserSqlDao;
use App\Domain\Entity\User;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\HashedPassword;

final class UserQueryService
{
    private UserSqlDao $userDao;

    public function __construct()
    {
        $this->userDao = new UserSqlDao();
    }

    /**
     * ユーザーを検索し、取得したレコードをUserエンティティとして返却
     * @param Email
     * @return User|null
     */
    public function findByMail(Email $email): ?User
    {
        $userMapper = $this->userDao->findByMail($email);
        return $this->existsUser($userMapper)
            ? new User(
                new UserId($userMapper['id']),
                new UserName($userMapper['name']),
                new Email($userMapper['email']),
                new HashedPassword($userMapper['password'])
            )
            : null;
    }

    /**
     * ユーザーの存在チェック
     * @param array|null $userMapper
     * @return bool
     */
    private function existsUser(?array $userMapper): bool
    {
        return !is_null($userMapper);
    }
}
