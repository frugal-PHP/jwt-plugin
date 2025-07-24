<?php

namespace FrugalPhpPlugin\Jwt\Helpers;

use FrugalPhpPlugin\Jwt\Entities\RefreshTokenEntity;
use FrugalPhpPlugin\Jwt\Repositories\RefreshTokenRepository;
use FrugalPhpPlugin\Orm\Helpers\UuidHelper;
use React\Promise\PromiseInterface;

class RefreshTokenHelper
{
    public static function create(string $userId) : PromiseInterface
    {
        $refreshTokenEntity = new RefreshTokenEntity();
        $refreshTokenEntity->token = UuidHelper::generateUuidV4();
        $refreshTokenEntity->userUuid = $userId;
        $refreshTokenRepository = new RefreshTokenRepository();

        return $refreshTokenRepository->create($refreshTokenEntity)
            ->then(function() use ($refreshTokenEntity){
                return $refreshTokenEntity;
            }
        );
    }
}