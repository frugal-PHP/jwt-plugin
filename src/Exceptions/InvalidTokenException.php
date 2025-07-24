<?php

namespace FrugalPhpPlugin\Jwt\Exceptions;

use Exception;
use React\Http\Message\Response;

class InvalidTokenException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            message: "Invalid token",
            code: Response::STATUS_FORBIDDEN
        );
    }
}