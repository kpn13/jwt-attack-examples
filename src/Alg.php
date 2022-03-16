<?php

namespace App;

class Alg
{
    const NONE = 'none';
    const HS256 = 'HS256';
    const RS256 = 'RS256';

    public static function getMethod(string $alg): string
    {
        return match($alg) {
            self::HS256, self::RS256 => 'sha256',
            self::NONE => 'none',
        };
    }
}