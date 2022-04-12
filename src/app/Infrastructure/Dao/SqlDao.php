<?php
namespace App\Infrastructure\Dao;

use \PDO;
use \PDOException;

/**
 * SQL形式のDAOベースクラス
 */
class SqlDao
{
    protected PDO $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                "mysql:dbname={$_ENV['DB_NAME']};host={$_ENV['DB_HOST']};",
                $_ENV['DB_USER'],
                $_ENV['DB_PASSWORD']
            );
        } catch (PDOException $e) {
            exit('DB接続エラー: ' . $e->getMessage());
        }
    }

    public function __destruct()
    {
        unset($this->pdo);
    }
}
