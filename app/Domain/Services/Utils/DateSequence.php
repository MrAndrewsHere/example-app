<?php

namespace App\Domain\Services\Utils;

use Carbon\Carbon;

class DateSequence
{
    static Carbon $current;

    /**
     * @return Carbon
     */
    public static function next(): Carbon
    {
        self::$current = (self::$current ?? Carbon::now())->copy()->addMinute();
        return self::$current;
    }


}
