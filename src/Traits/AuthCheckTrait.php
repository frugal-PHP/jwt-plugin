<?php

namespace FrugalPhpPlugin\Jwt\Traits;

use FrugalPhpPlugin\Jwt\Exceptions\InvalidTokenException;
use FrugalPhpPlugin\Jwt\Helpers\JwtHelper;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

trait AuthCheckTrait
{
    protected static function getTokenContent(ServerRequestInterface $request) : array
    {
        $auth = $request->getHeaderLine('Authorization');
        if (!$auth || !preg_match('/^Bearer\s+(.+)$/i', $auth, $m)) {
            throw new InvalidArgumentException(code: Response::STATUS_BAD_REQUEST, message: "No bearer token supplied.");
        }
        $jwt = $m[1];

        try {
            return JwtHelper::decode($jwt, getenv('JWT_SECRET'));
        } catch (\Throwable $e) {
            throw new InvalidTokenException(code: Response::STATUS_FORBIDDEN, message:"Invalid token. Unable to decode it. (".$e->getMessage().")");
        }
    }
}