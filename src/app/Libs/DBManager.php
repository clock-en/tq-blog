<?php
class DBManager
{
    public PDO $connection;
    public function __construct()
    {
        try {
            $this->connection = new PDO(
                "mysql:dbname={$_ENV['DB_NAME']};host={$_ENV['DB_HOST']};",
                $_ENV['DB_USER'],
                $_ENV['DB_PASSWORD']
            );
            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        } catch (PDOException $e) {
            echo 'Fatal Error: Connection failed.';
            die();
        }
    }
    public function __destruct()
    {
        unset($this->connection);
    }
}
