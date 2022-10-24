<?php

namespace App\Messages;

interface MessageContract
{
    /** Retrieve message
     * @return string
     */
    public function getMessage(): string;
}
