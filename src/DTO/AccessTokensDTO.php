<?php

namespace FrugalPhpPlugin\Jwt\DTO;

final readonly class AccessTokensDTO
{
    public function __construct(
        public string $accessToken, 
        public string $refreshToken
    ) {}
}