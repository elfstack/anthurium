<?php

namespace App\Exceptions;

use Exception;

class AlreadyEnrolledException extends Exception
{
    protected $message = 'You have already enrolled in this activity';
}
