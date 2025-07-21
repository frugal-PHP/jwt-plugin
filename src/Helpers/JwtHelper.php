<?php

namespace FrugalPhpPlugin\Jwt\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelper
{
    public static function encode(
        array $payload, 
        string $secret,
        string $algo = "HS256",
        int $ttl = 300
    ) : string {
        $now = time();
        $payload['iat'] = $now;

        if($ttl > 0) {
            $payload['exp'] = $now + $ttl;
        }

        return JWT::encode($payload, $secret, $algo);
    }

    public static function decode(
        string $token,
        string $secret,
        string $algo = "HS256"
    ) : array {
        return (array) JWT::decode($token, new Key($secret, $algo));
    }
}