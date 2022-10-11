<?php

namespace App\Domain\Services\Utils;

use Carbon\Carbon;

class DateGenerator
{
    public static Carbon|null $current = null;

    /**
     * @return \Generator
     */
    public static function step(): \Generator
    {
        self::$current = (self::$current ?? Carbon::now())->copy()->addMinute();
        yield self::$current;
    }


}
