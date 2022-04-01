<?php
class Utils
{
    static function array_sanitize(array $array)
    {
        $output = [];
        foreach ($array as $k => $v) {
            $output[$k] = htmlspecialchars(trim($v), ENT_QUOTES);
        }
        return $output;
    }
    static function array_some(array $array, callable $callable)
    {
        foreach ($array as $v) {
            if ($callable($v)) {
                return true;
            }
        }
        return false;
    }
    static function array_every(array $array, callable $callable)
    {
        foreach ($array as $v) {
            if (!$callable($v)) {
                return false;
            }
        }
        return true;
    }
}
