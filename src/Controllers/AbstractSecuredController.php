<?php

namespace FrugalPhpPlugin\Jwt\Controllers;

use Frugal\Core\Controllers\AbstractController;
use FrugalPhpPlugin\Jwt\Exceptions\InvalidTokenException;
use FrugalPhpPlugin\Jwt\Helpers\JwtHelper;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractSecuredController extends AbstractController
{
    protected array $tokenContent;

    public function __invoke(ServerRequestInterface $request)
    {
        $this->retrieveAccessToken($request);
    }

    protected function retrieveAccessToken(ServerRequestInterface $request)
    {
        $auth = $request->getHeaderLine('Authorization');
        if (!$auth || !preg_match('/^Bearer\s+(.+)$/i', $auth, $m)) {
            return null;
        }
        $jwt = $m[1];

        try {
            $this->tokenContent = JwtHelper::decode($jwt, getenv('JWT_SECRET'));
        } catch (\Throwable $e) {
            throw new InvalidTokenException();
        }
    }
}