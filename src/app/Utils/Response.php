<?php
namespace App\Utils;

class Response
{
    /**
     * リダイレクト
     * @param string $path
     */
    static function redirect(string $path): void
    {
        header("Location: {$path}");
        exit();
    }
}
