<?php

namespace Foundation\Exception;

class BadRequestException extends HttpException
{
    protected $statusCode = 400;
}
