<?php

namespace Tests;

use App\Attack\PublicKeyAsShared;
use App\Keystore;
use App\JWT;
use App\Verifier;
use PHPUnit\Framework\TestCase;

class PublicKeyAsSharedKeyAttackTest extends TestCase
{
    public function test_valid_jwt_rs256_should_return_true()
    {
        $jwt = new JWT('eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkthcmltIFBJTkNIT04iLCJpYXQiOjE1MTYyMzkwMjJ9.CtU20SV2ISsk6yjbYiAoqseXA-4qpbNziF1LMe3X3Oo693sO6-acbiT6vES4YudGSYlfmMnB_GzJRG2PT5cazThlvqtKu-75jnFyugKLO0eXS1_FCx8q9WpTq3hXfjMl5XMk_qjDIGBi42SazSjmFDDNRg3J95ZiRZk8g_wc2eoQ50JXDQzN10NBICVVYKyywr_v4_9ZKdm1lLf1ctajUqhRm_0wOwe9WnexTbe97uy56Tmb6KxwtnSI0RsW6KkWXG7Bt1ZvKdEHU-Kt6I7pn81-KrNlwfVpSXvUwtS-BfJuyRA7Q-UnpGRDkuumoDZ9HCQohobnQQfdjauJnvYsEQ');
        echo $jwt->compact();
        $this->assertTrue(Verifier::verify($jwt, Keystore::RSA_PUBLIC_KEY));
    }

    public function test_modified_jwt_rs256_should_return_false()
    {
        $jwt = new JWT('eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkthcmltIFBJTkNIT04iLCJpYXQiOjE1MTYyMzkwMjJ9.CtU20SV2ISsk6yjbYiAoqseXA-4qpbNziF1LMe3X3Oo693sO6-acbiT6vES4YudGSYlfmMnB_GzJRG2PT5cazThlvqtKu-75jnFyugKLO0eXS1_FCx8q9WpTq3hXfjMl5XMk_qjDIGBi42SazSjmFDDNRg3J95ZiRZk8g_wc2eoQ50JXDQzN10NBICVVYKyywr_v4_9ZKdm1lLf1ctajUqhRm_0wOwe9WnexTbe97uy56Tmb6KxwtnSI0RsW6KkWXG7Bt1ZvKdEHU-Kt6I7pn81-KrNlwfVpSXvUwtS-BfJuyRA7Q-UnpGRDkuumoDZ9HCQohobnQQfdjauJnvYsEQ');
        $jwt->claims['name'] = 'John DOE';
        echo $jwt->compact();
        $this->assertFalse(Verifier::verify($jwt, Keystore::RSA_PUBLIC_KEY));
    }

    public function test_modified_jwt_rs256_with_public_key_as_shared_secret_attack_should_return_true()
    {
        $jwt = new JWT('eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkthcmltIFBJTkNIT04iLCJpYXQiOjE1MTYyMzkwMjJ9.CtU20SV2ISsk6yjbYiAoqseXA-4qpbNziF1LMe3X3Oo693sO6-acbiT6vES4YudGSYlfmMnB_GzJRG2PT5cazThlvqtKu-75jnFyugKLO0eXS1_FCx8q9WpTq3hXfjMl5XMk_qjDIGBi42SazSjmFDDNRg3J95ZiRZk8g_wc2eoQ50JXDQzN10NBICVVYKyywr_v4_9ZKdm1lLf1ctajUqhRm_0wOwe9WnexTbe97uy56Tmb6KxwtnSI0RsW6KkWXG7Bt1ZvKdEHU-Kt6I7pn81-KrNlwfVpSXvUwtS-BfJuyRA7Q-UnpGRDkuumoDZ9HCQohobnQQfdjauJnvYsEQ');
        $jwt->claims['name'] = 'John DOE';

        $jwt = PublicKeyAsShared::attack($jwt);

        $this->assertTrue(Verifier::verify($jwt, Keystore::RSA_PUBLIC_KEY));
    }
}
