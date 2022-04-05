<?php
class Validator
{
    static function isNotBlank(string $value): bool
    {
        if ($value === '') {
            return false;
        }
        return true;
    }
    static function isMatch(string $value1, string $value2): bool
    {
        if ($value1 !== $value2) {
            return false;
        }
        return true;
    }
}
