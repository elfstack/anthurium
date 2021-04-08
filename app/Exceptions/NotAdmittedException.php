<?php

namespace App\Exceptions;

use Exception;

class NotAdmittedException extends Exception
{
    protected $message = 'You are not admitted in this activity';
}
