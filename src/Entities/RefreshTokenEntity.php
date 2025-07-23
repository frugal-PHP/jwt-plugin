<?php

namespace FrugalPhpPlugin\Jwt\Entities;

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
        return "refresh_token";
    }

    public static function getPrimaryKeyName(): string 
    { 
        return "token";
    }
}