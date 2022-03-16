<?php

namespace App;

use App\Utils\Base64Url;

class JWT
{
    public array $headers;
    public array $claims;
    public string $signature;

    public function __construct(string $jwt)
    {
        [$part1, $part2, $part3] = explode('.', $jwt);

        $this->headers = json_decode(Base64Url::decode($part1), true);
        $this->claims = json_decode(Base64Url::decode($part2), true);
        $this->signature = Base64Url::decode($part3);
    }

    public function compact(): string
    {
        return Base64Url::encode(json_encode($this->headers))
            . '.' .Base64Url::encode(json_encode($this->claims))
            . '.' .Base64Url::encode($this->signature);
    }
}
