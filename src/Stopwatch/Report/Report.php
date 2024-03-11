<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Report;

use Almasmurad\Stopwatch\Stopwatch\Event\Event;
use Almasmurad\Stopwatch\Stopwatch\Event\EventInterface;
use Almasmurad\Stopwatch\Stopwatch\Time\Time;
use Almasmurad\Stopwatch\Stopwatch\Time\TimeInterface;

/**
 * Report class is a simple implementation of ReportInterface for internal purposes.
 *
 * @internal
 */
final class Report implements ReportInterface
{
    const NON_VALUE = -1.0;

    /**
     * @var float
     */
    private $startTime = self::NON_VALUE;
    /**
     * @var float
     */
    private $finishTime = self::NON_VALUE;
    /**
     * @var float
     */
    private $allSeconds = self::NON_VALUE;

    public function getStartEvent(): EventInterface
    {
        return $this->makeEvent($this->startTime);
    }

    public function getFinishEvent(): EventInterface
    {
        return $this->makeEvent($this->finishTime);
    }

    public function getAllTime(): TimeInterface
    {
        return $this->makeTime($this->allSeconds);
    }

    /**
     * @return void
     */
    public function setStartTime(float $time)
    {
        if ($time < 0) {
            throw new \InvalidArgumentException("Time cannot be negative");
        }
        $this->startTime = $time;
    }

    /**
     * @return void
     */
    public function setFinishTime(float $time)
    {
        if ($time < 0) {
            throw new \InvalidArgumentException("Time cannot be negative");
        }
        $this->finishTime = $time;
    }

    /**
     * @return void
     */
    public function setAllSeconds(float $seconds)
    {
        if ($seconds < 0) {
            throw new \InvalidArgumentException("Seconds cannot be negative");
        }
        $this->allSeconds = $seconds;
    }

    /**
     * @param float $time
     * @return Event
     */
    private function makeEvent(float $time): Event
    {
        return $time == self::NON_VALUE ? Event::createNonHappened() : Event::createHappened($time);
    }

    /**
     * @param float $seconds
     * @return Time
     */
    private function makeTime(float $seconds): Time
    {
        return $seconds == self::NON_VALUE ? Time::createNonMeasured() : Time::createMeasured($seconds);
    }

}
