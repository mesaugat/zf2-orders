<?php

namespace Foundation\Exception;

class ValidationException extends \Exception
{
    protected $validationMessages = [];

    public function __construct($message = "", array $validationMessages)
    {
        parent::__construct($message);
        $this->validationMessages = $validationMessages;
    }

    public function getValidationMessages()
    {
        return $this->validationMessages;
    }
}
