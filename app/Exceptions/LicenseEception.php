<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class LicenseEception extends Exception
{
    public function __construct(string $message = "License Expired", int $code = 0, Throwable $previous = null)
    {
        new HttpException(419,$message,$previous);
    }
}
