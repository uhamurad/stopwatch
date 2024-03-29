<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Report;

use Almasmurad\Stopwatch\Event\Common\EventInterface;
use Almasmurad\Stopwatch\Event\Event;
use Almasmurad\Stopwatch\Report\Common\ReportInterface;
use Almasmurad\Stopwatch\Time\Common\TimeInterface;
use Almasmurad\Stopwatch\Time\Time;

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

    /**
     * @var non-empty-string[]
     */
    private $notices = [];

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
     * @param non-empty-string $notice
     * @return void
     */
    public function addNotice(string $notice)
    {
        $this->notices[] = $notice;
    }

    /**
     * @return non-empty-string[]
     */
    public function getNotices(): array
    {
        return $this->notices;
    }

    public function hasNotices(): bool
    {
        return isset($this->notices[0]);
    }

    private function makeEvent(float $time): Event
    {
        return $time == self::NON_VALUE ? Event::createNonHappened() : Event::createHappened($time);
    }

    private function makeTime(float $seconds): Time
    {
        return $seconds == self::NON_VALUE ? Time::createNonMeasured() : Time::createMeasured($seconds);
    }

}
