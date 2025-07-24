<?php

namespace Frugal\Core\Controllers;

use Frugal\Core\Controllers\AbstractController;
use FrugalPhpPlugin\Jwt\Helpers\JwtHelper;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractSecuredController extends AbstractController
{
    protected function getTokenPayload(ServerRequestInterface $request) : ?array
    {
        $auth = $request->getHeaderLine('Authorization');
        if (!$auth || !preg_match('/^Bearer\s+(.+)$/i', $auth, $m)) {
            return null;
        }
        $jwt = $m[1];

        try {
            return JwtHelper::decode($jwt, getenv('JWT_SECRET'));
        } catch (\Throwable $e) {
            return null;
        }
    }
}