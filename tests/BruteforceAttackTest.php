<?php

namespace Tests;

use App\Attack\BruteForce;
use App\JWT;
use PHPUnit\Framework\TestCase;

class BruteforceAttackTest extends TestCase
{
    public function test_valid_jwt_should_return_true()
    {
        $jwt = new JWT('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRE9FIiwiaWF0IjoxNTE2MjM5MDIyfQ.4S-YE90RGD4tuSmFq_PRgKvjy3I3pKY_JHirFm7VF8E');

        $secretKey = BruteForce::attack($jwt);

        $this->assertEquals('azert', $secretKey);
    }
}
