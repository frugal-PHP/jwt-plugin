<?php

namespace FrugalPhpPlugin\Jwt\Controllers;

use Frugal\Core\Controllers\AbstractController;
use FrugalPhpPlugin\Jwt\Exceptions\InvalidTokenException;
use FrugalPhpPlugin\Jwt\Helpers\JwtHelper;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

use function React\Promise\resolve;

abstract class AbstractSecuredController extends AbstractController
{
    protected array $tokenContent;

    public function __invoke(ServerRequestInterface $request)
    {
        try {
            $this->retrieveAccessToken($request);
        } catch (InvalidTokenException $e) {
            return resolve($this->sendJsonResponse(Response::STATUS_UNAUTHORIZED, $e->getMessage()));
        }
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