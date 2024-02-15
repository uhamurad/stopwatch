<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch;

interface StopwatchWithoutSugarInterface
{
    public function start(): StopwatchInterface;

    public function stop(): StopwatchInterface;

    public function report(): StopwatchInterface;
}
