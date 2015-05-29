<?php

namespace Foundation\Misc;


class JsonResponse extends Response
{
    public function __construct($data = null, $status = 200, array $headers = [])
    {
        $data = (new JsonSerializer())->serialize($data);

        parent::__construct($data, $status, $headers);

        $this->getHeaders()->addHeaderLine('Content-Type', 'application/json');
    }
}
