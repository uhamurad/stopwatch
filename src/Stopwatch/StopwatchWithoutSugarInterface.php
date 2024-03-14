<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch;

use Almasmurad\Stopwatch\Stopwatch\Report\ReportInterface;

interface StopwatchWithoutSugarInterface
{
    public function start(): StopwatchInterface;

    public function stop(): StopwatchInterface;

    public function report(): StopwatchInterface;

    public function getReport(): ReportInterface;
}
