<?php

namespace FrugalPhpPlugin\Jwtauth\DTO;

final readonly class AccessTokensDTO
{
    public function __construct(
        public string $accessToken, 
        public string $refreshToken
    ) {}
}