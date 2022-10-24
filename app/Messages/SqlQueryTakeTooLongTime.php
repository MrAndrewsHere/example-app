<?php

namespace App\Messages;

class SqlQueryTakeTooLongTime extends Message
{
    protected string $message = 'Долгое выполнение sql запроса';
    public function __construct(string|int|float $time)
    {
        $this->message.= " ($time ms)";
        parent::__construct($this->message);
    }
}
