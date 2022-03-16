<?php

namespace App\Utils;

class Base64Url
{
    public static function encode(string $text): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($text));
    }

    public static function decode(string $text): string
    {
        return base64_decode(strtr($text, '-_', '+/'), true);
    }
}
