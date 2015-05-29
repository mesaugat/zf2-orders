<?php

namespace Foundation\Misc;

use Zend\Http\Headers;
use Zend\Http\Response as ZendResponse;

class Response extends ZendResponse
{
    public function __construct($data = null, $status = 200, array $headers = [])
    {
        $this->setContent($data);
        $this->setStatusCode($status);

        $headers = new Headers();
        foreach ($headers as $key => $value) {
            $headers->addHeaderLine($key, $value);
        }
        $this->setHeaders($headers);
    }
}
