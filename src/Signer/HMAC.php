<?php

namespace App\Signer;

use App\Alg;
use App\JWT;
use App\Utils\Base64Url;

class HMAC
{
    public static function sign(array $headers, array $claims, string $sharedSecret): JWT
    {
        $header = Base64Url::encode(json_encode($headers));
        $payload = Base64Url::encode(json_encode($claims));

        $signature = hash_hmac(
            Alg::getMethod($headers['alg']),
            $header . "." . $payload,
            $sharedSecret,
            true
        );

        $signature = Base64Url::encode($signature);

        return new JWT($header.'.'.$payload.'.'.$signature);
    }
}