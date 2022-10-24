<?php

namespace App\Messages;

use Illuminate\Notifications\Notifiable;

/**
 * Notifiable message
 */
abstract class Message implements MessageContract
{
    use Notifiable;

    /**
     * @var string|mixed
     */
    protected string $app;

    /**
     * @var string|mixed
     */
    protected string $domain;

    /**
     * @param string $message
     */
    public function __construct(protected string $message)
    {
        $this->app = env('APP_NAME');
        $this->domain = parse_url(env('APP_URL'))['host'] ?? '';
    }

    /** Concat message with the string
     * @param string $string
     * @return void
     */
    public function add(string $string): void
    {
        $this->message .= $string;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return implode("\n", [
            "App: $this->app",
            "URL: $this->domain",
            '----',
            $this->message
        ]);
    }
}
