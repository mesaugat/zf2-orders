<?php

namespace Foundation\Exception;

use Foundation\Misc\JsonResponse;

class HttpException extends \Exception
{
    protected $statusCode = 500;

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getResponse()
    {
        return new JsonResponse([
            'message' => $this->getMessage(),
        ], $this->getStatusCode());
    }
}
