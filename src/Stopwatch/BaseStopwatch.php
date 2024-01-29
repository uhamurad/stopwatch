<?php

namespace Almasmurad\Stopwatch\Stopwatch;

final class BaseStopwatch implements StopwatchInterface
{

    /**
     * The start time of the process.
     *
     * @var float
     */
    private $startTimestamp = 0;
    /**
     * The end time of the process.
     *
     * @var float
     */
    private $endTimestamp = 0;

    public function start(): StopwatchInterface
    {
        $this->startTimestamp = $this->getCurrentTimestamp();
        return $this;
    }

    public function stop(): StopwatchInterface
    {
        $this->endTimestamp = $this->getCurrentTimestamp();
        return $this;
    }

    public function report(): StopwatchInterface
    {

        $elapsed = $this->endTimestamp - $this->startTimestamp;

        $startedStr = date('r', $this->startTimestamp);
        $elapsedStr = number_format($elapsed, 3, '.', ' ');

        $message = "Started at {$startedStr}\n";
        $message .= str_repeat('‾', mb_strlen($message))."\n";
        $message .= "All time | {$elapsedStr}s\n";

        echo $message;

        return $this;
    }

    /**
     * @return mixed
     */
    private function getCurrentTimestamp()
    {
        return microtime(true);
    }


}