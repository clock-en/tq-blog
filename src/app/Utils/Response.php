<?php
namespace App\Utils;

class Response
{
    /**
     * リダイレクト
     * @param string $path
     * @param int $statusCode
     */
    static function redirect(string $path, int $statusCode = null): void
    {
        header("Location: {$path}", true, $statusCode);
        exit();
    }
}
