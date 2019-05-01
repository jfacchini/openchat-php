<?php

namespace App\Domain;

use RuntimeException;
use Throwable;

class UnableToCreateUuid extends RuntimeException
{
    private function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function dueToException(Throwable $previous): self
    {
        return new self('Unable to generate next Uuid due to a previous exception', 0, $previous);
    }
}
