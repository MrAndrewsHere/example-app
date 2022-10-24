<?php

namespace Database\Seeders;

use Illuminate\Console\OutputStyle;
use Illuminate\Console\View\Components\Info;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\ConsoleOutput;

trait TimeInfo
{
    protected float $start;

    public function start(): void
    {
        $this->start = microtime(true);
    }

    public function end(): void
    {
        $info = implode(' ', [
            static::class,
            'complete in',
            (round(microtime(true) - $this->start, 1)),
            'sec',
        ]);
        (new Info(new OutputStyle(new StringInput(''), new ConsoleOutput())))
            ->render($info);
    }
}
