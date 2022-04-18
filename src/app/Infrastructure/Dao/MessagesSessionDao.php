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

    /**
     * flashメッセージの取得
     * @return array | null
     */
    public function getMessages(): ?array
    {
        if (!empty($this->messages)) {
            return $this->messages;
        }
        return null;
    }

    /**
     * flashメッセージの設定
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $_SESSION[self::SESSION_NAME][] = $message;
    }
}
