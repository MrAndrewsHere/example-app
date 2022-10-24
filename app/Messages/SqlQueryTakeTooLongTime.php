<?php

namespace App\Messages;

/**
 * Сообщение о долгом выполнении sql запроса
 */
class SqlQueryTakeTooLongTime extends TgMessage
{
    /**
     * @var string
     */
    protected string $message = 'Долгое выполнение sql запроса';

    public function __construct(?string $message = null, ?string $chat_id = null, float|int|string|null $time = null)
    {
        if ($time) {
            $this->message .= " ($time ms)";
        }
        parent::__construct($this->message, $chat_id);
        $this->concat($message);
    }
}
