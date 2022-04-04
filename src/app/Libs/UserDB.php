<?php
require_once 'DBManager.php';

class UserDB
{
    static function findByMailWithPassword(
        string $email,
        string $password
    ): ?array {
        $db = new DBManager();
        $sql = 'SELECT * FROM users WHERE email=:email AND password=:password';
        $statement = $db->connection->prepare($sql);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(
            ':password',
            hash('sha256', $password),
            PDO::PARAM_STR
        );
        $res = $statement->execute();
        if (!$res) {
            throw new PDOException('予期せぬ不具合が発生しました。');
        }
        $user = $statement->fetch();
        return $user ? $user : null;
    }
    static function findByMail(string $email): ?array
    {
        $db = new DBManager();
        $sql = 'SELECT email FROM users WHERE email=:email';
        $statement = $db->connection->prepare($sql);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $res = $statement->execute();
        if (!$res) {
            throw new PDOException('予期せぬ不具合が発生しました。');
        }
        $user = $statement->fetch();
        return $user ? $user : null;
    }
    static function create(string $name, string $email, string $password)
    {
        $db = new DBManager();
        $insertSQL =
            'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';
        $stmt = $db->connection->prepare($insertSQL);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(
            ':password',
            hash('sha256', $password),
            PDO::PARAM_STR
        );
        $res = $stmt->execute();
        if (!$res) {
            throw new PDOException('予期せぬ不具合が発生しました。');
        }
    }
}
