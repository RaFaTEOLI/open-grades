<?php

namespace App\Http\Controllers\API;

class HttpStatus
{
    const SUCCESS = 200;
    const CREATED = 201;
    const NO_CONTENT = 204;
    const BAD_REQUEST = 400;
    const UNPROCESSABLE_ENTITY = 422;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const SERVER_ERROR = 500;
}
