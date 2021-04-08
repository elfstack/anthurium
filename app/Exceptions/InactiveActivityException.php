<?php

namespace App\Exceptions;

use Exception;

class InactiveActivityException extends Exception
{
    protected $message = 'Inactive activity';
}
