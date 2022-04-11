<?php
namespace App\Utils;

class Validator
{
    /**
     * サニタイズ処理
     * @param string $value
     * @return string
     */
    static function sanitize(string $value): string
    {
        return htmlspecialchars(trim($value), ENT_QUOTES);
    }

    /**
     * 未入力チェック
     * @param string $value
     * @return bool
     */
    static function isNotBlank(string $value): bool
    {
        if ($value === '') {
            return false;
        }
        return true;
    }

    /**
     * 値比較チェック
     * @param string $value1
     * @param string $value2
     * @return bool
     */
    static function isMatch(string $value1, string $value2): bool
    {
        if ($value1 !== $value2) {
            return false;
        }
        return true;
    }
}
