<?php

namespace Tests;

use App\Attack\None;
use App\JWT;
use App\Keystore;
use App\Verifier;
use PHPUnit\Framework\TestCase;

class NoneAttackTest extends TestCase
{
    public function test_valid_jwt_should_return_true()
    {
        $jwt = new JWT('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkthcmltIFBJTkNIT04iLCJpYXQiOjE1MTYyMzkwMjJ9.6EPoAg7oUAjSpsQEeO7h6uoCOjzMOqIuIi3MkZX1zB4');

        $this->assertTrue(Verifier::verify($jwt, Keystore::SHARED_SECRET));
    }

    public function test_modified_jwt_should_return_false()
    {
        $jwt = new JWT('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkthcmltIFBJTkNIT04iLCJpYXQiOjE1MTYyMzkwMjJ9.6EPoAg7oUAjSpsQEeO7h6uoCOjzMOqIuIi3MkZX1zB4');
        $jwt->claims['name'] = 'John DOE';

        $this->assertFalse(Verifier::verify($jwt, Keystore::SHARED_SECRET));
    }

    public function test_modified_jwt_should_return_true_with_none_attack()
    {
        $jwt = new JWT('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkthcmltIFBJTkNIT04iLCJpYXQiOjE1MTYyMzkwMjJ9.6EPoAg7oUAjSpsQEeO7h6uoCOjzMOqIuIi3MkZX1zB4');
        $jwt->claims['name'] = 'John DOE';

        $jwt = None::attack($jwt);
echo $jwt->compact();
        $this->assertTrue(Verifier::verify($jwt,Keystore::SHARED_SECRET));
    }
}
