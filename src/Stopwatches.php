<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch;

use Almasmurad\Stopwatch\Stopwatch\BaseStopwatch;
use Almasmurad\Stopwatch\Stopwatch\StopwatchInterface;

abstract class Stopwatches
{
    public static function simple(): StopwatchInterface
    {
        return new BaseStopwatch();
    }
}
