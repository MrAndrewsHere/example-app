<?php

namespace App\Domain\Exceptions;

use Exception;

class AdNotFound extends Exception
{
    /**
     * @var string
     */
    protected $message = "Ad not found";

    /**
     * @var int
     */
    protected $code = 404;
}
