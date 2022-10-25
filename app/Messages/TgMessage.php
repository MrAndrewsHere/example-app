<?php

namespace App\Messages;

use App\Notifications\TelegramNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Mockery\MockInterface;
use NotificationChannels\Telegram\Telegram;
use Throwable;
use Mockery;

/**
 * Notifiable message
 */
abstract class TgMessage implements MessageContract
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
     * @param string|null $chat_id
     */
    public function __construct(protected string $message, protected ?string $chat_id = null)
    {
        $this->app = env('APP_NAME');
        $this->domain = parse_url(env('APP_URL'))['host'] ?? '';
        $this->chat_id ??= env('TELEGRAM_CHAT_ID');
    }

    /** Concat message with the string
     * @param string|null $string
     * @return static
     */
    public function concat(?string $string): static
    {
        if (!$string) {
            return $this;
        }
        $this->message .= "\n$string";

        return $this;
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

    /**
     * @return void
     */
    public function send(): void
    {
        if ($this->chat_id) {
            try {
                $this->notify(new TelegramNotification());
            } catch (Throwable $exception) {
                Log::error($exception->getMessage());
            }
        }
    }

    public function __invoke()
    {
        $this->send();
    }

    public static function registerTelegramMock(): void
    {
        if (!env('TELEGRAM_BOT_TOKEN')) {
            app()->instance(
                Telegram::class,
                Mockery::mock(Telegram::class, function (MockInterface $mock) {
                    $mock->shouldReceive('process');
                })
            );
        }
    }

    /**
     * @return string|null
     */
    public function getChatId(): ?string
    {
        return $this->chat_id;
    }
}
