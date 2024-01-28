<?php

namespace Almasmurad\Stopwatch;

use Almasmurad\Stopwatch\Stopwatch\BaseStopwatch;

abstract class Stopwatches
{
    public static function simple()
    {
        return new BaseStopwatch();
    }
}