<?php

namespace App\Core\Exceptions;

use \Exception;

class ValidatorException extends Exception
{
    public $errors;

    public function __construct($errors)
    {
        parent::__construct("Validation exception");
        $this->errors = $errors;
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
