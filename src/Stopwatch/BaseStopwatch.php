<?php

namespace Almasmurad\Stopwatch\Stopwatch;

final class BaseStopwatch implements StopwatchInterface
{

    /**
     * The start time of the process.
     *
     * @var int
     */
    private $startTimestamp = 0;
    /**
     * The end time of the process.
     *
     * @var int
     */
    private $endTimestamp = 0;

    public function start(): StopwatchInterface
    {
        return $this;
    }

    public function stop(): StopwatchInterface
    {
        return $this;
    }

    public function report(): StopwatchInterface
    {
        return $this;
    }


}