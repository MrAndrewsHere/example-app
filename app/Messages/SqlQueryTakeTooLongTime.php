<?php

namespace App\Messages;

/**
 * Сообщение о долгом выполнении sql запроса
 */
class SqlQueryTakeTooLongTime extends Message
{
    /**
     * @var string
     */
    protected string $message = 'Долгое выполнение sql запроса';

    /**
     * @param string|int|float $time
     */
    public function __construct(string|int|float $time)
    {
        $this->message .= " ($time ms)";
        parent::__construct($this->message);
    }
}
