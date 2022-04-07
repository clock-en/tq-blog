<?php
namespace App\Infrastructure\DAO;

use \PDO;

final class UserDAO extends SqlDAO
{
    const TABLE_NAME = 'users';

    /**
     * ユーザー追加
     */
    public function create(string $name, string $email, string $password): void
    {
        $sql = sprintf(
            'INSERT INTO %s (name, email, password) VALUES (:name, :email, :password)',
            self::TABLE_NAME
        );
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * ユーザー検索
     */
    public function findByMail(string $email): ?array
    {
        $sql = sprintf('SELECT * FROM %s WHERE email=:email', self::TABLE_NAME);
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch();
        return $user ? $user : null;
    }
}
