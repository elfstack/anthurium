<?php

namespace App\Exceptions;

use Exception;

class AlreadyProcessedException extends Exception
{
    protected $message = 'Your request are in process';
}
