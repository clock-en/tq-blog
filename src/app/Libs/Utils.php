<?php
class Utils
{
    static function sanitize(string $value): string
    {
        return htmlspecialchars(trim($value), ENT_QUOTES);
    }
    static function redirect(string $path): void
    {
        header("Location: {$path}");
        exit();
    }
}
