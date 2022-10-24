<?php

namespace App\Messages;

use Illuminate\Notifications\Notifiable;

class Message implements MessageContract
{
    use Notifiable;

    protected string $app;
    protected string $domain;

    public function __construct(protected string $message)
    {
        $this->app = env('APP_NAME');
        $this->domain = parse_url(env('APP_URL'))['host'] ?? '';
    }

    public function add(string $message)
    {
        $this->message .= $message;
    }

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
