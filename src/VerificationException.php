<?php

namespace App\Exceptions;

use Exception;

class VerificationException extends Exception
{
    protected $message = 'Message about hte wrong verification';
}
