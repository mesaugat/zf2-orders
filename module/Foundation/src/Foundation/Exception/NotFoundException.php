<?php

namespace Foundation\Exception;

class NotFoundException extends HttpException
{
    protected $statusCode = 404;
}
