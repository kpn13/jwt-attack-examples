<?php

namespace App\Signer;

use App\Alg;
use App\JWT;
use App\Utils\Base64Url;

class RSA
{
    public static function sign(array $headers, array $claims, string $privateKey): JWT
    {
        $signature = '';
        $header = Base64Url::encode(json_encode($headers));
        $payload = Base64Url::encode(json_encode($claims));

        \openssl_sign($header.'.'.$payload, $signature, $privateKey, Alg::getMethod($headers['alg']));

        $signature = Base64Url::encode($signature);

        return new JWT($header.'.'.$payload.'.'.$signature);
    }
}