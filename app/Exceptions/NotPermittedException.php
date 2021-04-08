<?php


namespace App\Exceptions;


use Throwable;

class NotPermittedException extends \Exception
{
    protected $message = 'You are not permitted to join this activity';
}
