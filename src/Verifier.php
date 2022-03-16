<?php

namespace App;

use App\Utils\Base64Url;

class Verifier
{
    public static function verify(JWT $jwt, string $sharedOrPublicKey): bool
    {
        if ($jwt->headers['alg'] === Alg::NONE) {
            return true;
        }

        if ($jwt->headers['alg'] === Alg::HS256) {
            $computedSignature = hash_hmac(
                Alg::getMethod($jwt->headers['alg']),
                Base64Url::encode(json_encode($jwt->headers)) . "." . Base64Url::encode(json_encode($jwt->claims)),
                $sharedOrPublicKey,
                true,
            );

            return $jwt->signature === $computedSignature;
        }

        if ($jwt->headers['alg'] === Alg::RS256) {
            $success = \openssl_verify(
                Base64Url::encode(json_encode($jwt->headers)) . "." . Base64Url::encode(json_encode($jwt->claims)),
                $jwt->signature,
                Keystore::RSA_PUBLIC_KEY,
                Alg::getMethod(Alg::RS256),
            );

            return $success === 1;
        }

        return false;
    }
}