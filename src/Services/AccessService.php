<?php

namespace FrugalPhpPlugin\Jwtauth\Services;

use Frugal\Core\Services\FrugalContainer;
use FrugalPhpPlugin\Jwt\Helpers\JwtHelper;
use FrugalPhpPlugin\Jwtauth\DTO\AccessTokensDTO;
use FrugalPhpPlugin\Jwtauth\Entities\RefreshTokenEntity;
use FrugalPhpPlugin\Jwtauth\Helpers\RefreshToken;
use FrugalPhpPlugin\Jwtauth\Repositories\RefreshTokenRepository;
use React\Promise\PromiseInterface;

class AccessService
{
    public static function grant(array $tokenPayload, string $userId) : PromiseInterface
    {
        return RefreshToken::create(userId: $userId)
            ->then(function(RefreshTokenEntity $entity) use($tokenPayload) {
                return new AccessTokensDTO(
                    accessToken: JwtHelper::encode($tokenPayload, getenv('JWT_SECRET')),
                    refreshToken: $entity->token
                );
            });
    }

    public static function revoke(string $refreshTokenId) : PromiseInterface
    {
        $db = FrugalContainer::getInstance()->get('tokenOrm');
        $repository = new RefreshTokenRepository($db);
        
        /** @var RefreshToken */
        return $repository->findOneById($refreshTokenId)
            ->then(function(?RefreshTokenEntity $entity) use ($repository) {
                if($entity !== null) {
                    return $repository->delete($entity);
                }
            });
    }
}