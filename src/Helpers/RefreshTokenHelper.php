<?php

namespace FrugalPhpPlugin\Jwt\Helpers;

use Frugal\Core\Services\FrugalContainer;
use FrugalPhpPlugin\Jwt\Entities\RefreshTokenEntity;
use FrugalPhpPlugin\Jwt\Repositories\RefreshTokenRepository;
use FrugalPhpPlugin\Orm\Helpers\UuidHelper;
use React\Promise\PromiseInterface;

class RefreshToken
{
    public static function create(string $userId) : PromiseInterface
    {
        $refreshTokenEntity = new RefreshTokenEntity();
        $refreshTokenEntity->token = UuidHelper::generateUuidV4();
        $refreshTokenEntity->userUuid = $userId;
        $db = FrugalContainer::getInstance()->get('tokenOrm');

        $refreshTokenRepository = new RefreshTokenRepository(db: $db);

        return $refreshTokenRepository->create($refreshTokenEntity)
            ->then(function() use ($refreshTokenEntity){
                return $refreshTokenEntity;
            }
        );
    }
}