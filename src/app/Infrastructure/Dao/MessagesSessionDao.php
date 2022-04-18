<?php
namespace App\Infrastructure\Dao;

final class MessagesSessionDao
{
    const SESSION_NAME = 'messages';

    private $messages = [];

    public function __construct()
    {
        $this->messages = $_SESSION[self::SESSION_NAME];
        unset($_SESSION[self::SESSION_NAME]);
    }

    public function getMessages(): ?array
    {
        if (!empty($this->messages)) {
            return $this->messages;
        }
        return null;
    }

    public function setMessage(string $message): void
    {
        $_SESSION[self::SESSION_NAME][] = $message;
    }
}
