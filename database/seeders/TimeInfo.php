<?php

namespace Database\Seeders;

use Illuminate\Console\OutputStyle;
use Illuminate\Console\View\Components\Info;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\ConsoleOutput;

trait TimeInfo
{
    /**
     * @var float
     */
    protected float $start;
    protected string $message;
    protected bool $withInput = true;

    /**
     * Start timer
     *
     * @return void
     */
    public function start(): void
    {
        $this->start = microtime(true);
    }

    /**
     * Stop timer and print info message
     *
     * @return TimeInfo
     */
    public function end(): static
    {
        $sec = round(microtime(true) - $this->start, 1);
        $this->message = implode(' ', [
            static::class,
            'complete in',
            $sec,
            'sec',
        ]);
        $this->printer();
        return $this;
    }

    /**
     * @return void
     */
    protected function printer(): void
    {
        if ($this->withInput) {
            (new Info(new OutputStyle(new StringInput(''), new ConsoleOutput())))->render($this->message);
        }
    }

    /**
     * @param bool $withInput
     * @return TimeInfo
     */
    public function setWithInput(bool $withInput): static
    {
        $this->withInput = $withInput;
        return $this;
    }
}
