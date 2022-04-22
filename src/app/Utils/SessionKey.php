<?php
namespace App\Utils;

use Exception;

final class SessionKey
{
    public const ERRORS_KEY = 'errors';
    public const FORM_INPUTS_KEY = 'formInputs';
    public const MESSAGES_KEY = 'messages';
    public const USER_KEY = 'user';

    private const KEYS = [
        self::ERRORS_KEY,
        self::FORM_INPUTS_KEY,
        self::MESSAGES_KEY,
        self::USER_KEY,
    ];

    private $keyName;

    public function __construct(string $keyName)
    {
        if (!in_array($keyName, self::KEYS)) {
            throw new Exception('使用不可能なキーです');
        }
        $this->keyName = $keyName;
    }

    /**
     * キー名を取得
     * @return string
     */
    public function getKeyName(): string
    {
        return $this->keyName;
    }
}
