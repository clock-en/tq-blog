<?php
namespace App\Infrastructure\Dao;

use PDO;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\User\NewUser;

final class UserSqlDao extends SqlDao
{
    const TABLE_NAME = 'users';

    /**
     * ユーザー追加
     * @param NewUser $user
     */
    public function create(NewUser $user): void
    {
        $sql = sprintf(
            'INSERT INTO %s (name, email, password) VALUES (:name, :email, :password)',
            self::TABLE_NAME
        );
        $name = $user->name();
        $email = $user->email();
        $hashedPassword = $user->password()->hash();

        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':name', $name->value(), PDO::PARAM_STR);
        $statement->bindParam(':email', $email->value(), PDO::PARAM_STR);
        $statement->bindParam(
            ':password',
            $hashedPassword->value(),
            PDO::PARAM_STR
        );
        $statement->execute();
    }

    /**
     * ユーザー検索
     * @param Email $email
     * @return array|null
     */
    public function findByMail(Email $email): ?array
    {
        $sql = sprintf('SELECT * FROM %s WHERE email=:email', self::TABLE_NAME);
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':email', $email->value(), PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch();
        return $user ? $user : null;
    }
}
