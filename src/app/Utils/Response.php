<?php
namespace App\Utils;

class Response
{
    /**
     * リダイレクト
     */
    static function redirect(string $path): void
    {
        header("Location: {$path}");
        exit();
    }
}
