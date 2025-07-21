<?php

namespace FrugalPhpPlugin\Jwtauth\Entities;

use FrugalPhpPlugin\Orm\Entities\AbstractEntity;

class RefreshTokenEntity extends AbstractEntity
{
    public string $token;
    public string $userUuid;
    public bool $isExpired = false;
    public ?string $expireAt = null;

    public static function getFields(): array 
    {
        return [
            "token" => "token",
            "userUuid" => "user_uuid",
            "isExpired" => "is_expired",
            "expireAt" => "expire_at"
        ];
    }

    public static function getTableName(): string 
    { 
        return "RefreshToken";
    }

    public static function getPrimaryKeyName(): string 
    { 
        return "token";
    }
}