<?php
namespace App\Infrastructure\Dao;

use PDO;
use PDOException;

/**
 * SQL形式のDAOベースクラス
 */
abstract class SqlDao
{
    protected PDO $pdo;

    public function __construct()
    {
        try {
            $dbUrl = "mysql:dbname={$_ENV['DB_NAME']};";

            if ($_ENV['APP_ENV'] == 'prod') {
                $dbUrl = $dbUrl . "unix_socket={$_ENV['DB_SOCKET_PATH']};";
            } else {
                $dbUrl = $dbUrl . "host={$_ENV['DB_HOST']};";
            }

            $this->pdo = new PDO(
                $dbUrl,
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
