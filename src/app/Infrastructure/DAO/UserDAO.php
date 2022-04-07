<?php
namespace App\Infrastructure\DAO;

use \PDO;

final class UserDAO extends SqlDAO
{
    const TABLE_NAME = 'user';

    public function create(string $name, string $email, string $password)
    {
        $sql = sprintf(
            'INSERT INTO %s (name, email, password) VALUES (:name, :email, :password)',
            self::TABLE_NAME
        );
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->execute();
    }
    public function findByMail(string $email): ?array
    {
        $sql = sprintf('SELECT * FROM %s WHERE email=:email', self::TABLE_NAME);
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $user = $statement->fetch();
        return $user ? $user : null;
    }
}
