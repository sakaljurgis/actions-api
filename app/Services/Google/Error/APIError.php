<?php

namespace App\Services\Google\Error;

use Exception;

class APIError extends Exception
{
    public $code;
    public $message;

    public function __construct(string $message, int $code)
    {
        parent::__construct($message);

        $this->code = $code;
        $this->message = $message;
    }
}
