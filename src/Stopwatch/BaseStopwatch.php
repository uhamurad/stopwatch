<?php

namespace Almasmurad\Stopwatch\Stopwatch;

use Almasmurad\Stopwatch\Stopwatch\Notices\NoticesCollection;
use Almasmurad\Stopwatch\Stopwatch\Notices\StartMissedNotice;
use Almasmurad\Stopwatch\Stopwatch\Notices\StartSkippedNotice;
use Almasmurad\Stopwatch\Stopwatch\Notices\StopMissedNotice;
use Almasmurad\Stopwatch\Stopwatch\Notices\StopSkippedNotice;

final class BaseStopwatch implements StopwatchInterface
{

    /**
     * @var float
     */
    private $createTimestamp = 0;
    /**
     * @var float
     */
    private $startTimestamp = 0;
    /**
     * @var float
     */
    private $stopTimestamp = 0;
    /**
     * @var float
     */
    private $reportTimestamp = 0;
    /**
     * @var NoticesCollection
     */
    private $notices;

    public function __construct()
    {
        $this->createTimestamp = $this->getCurrentTimestamp();
        $this->notices = new NoticesCollection();
    }

    public function start(): StopwatchInterface
    {
        if (!$this->skipStartIfNecessary()) {
            $this->startTimestamp = $this->getCurrentTimestamp();
        };
        return $this;
    }

    public function stop(): StopwatchInterface
    {
        if (!$this->skipStopIfNecessary()) {
            $this->stopTimestamp = $this->getCurrentTimestamp();
            $this->correctStartTimestampIfNecessary();
        }
        return $this;
    }

    public function report(): StopwatchInterface
    {

        $this->reportTimestamp = $this->getCurrentTimestamp();

        $this->correctStartTimestampIfNecessary();
        $this->correctStopTimestampIfNecessary();

        $elapsed = $this->stopTimestamp - $this->startTimestamp;

        $startedStr = date('r', (int)$this->startTimestamp);
        $elapsedStr = number_format($elapsed, 3, '.', ' ');

        $message = "Started at {$startedStr}\n";
        $breakLineLength = mb_strlen($message);
        $breakLine = str_repeat('‾', $breakLineLength)."\n";
        $message .= $breakLine;
        $message .= "All time | {$elapsedStr}s\n";

        if ($this->notices->hasNotices()){
            $message .= $breakLine;
            $message .= "Notices:\n";
            foreach ($this->notices->getAllNotices() as $notice) {
                $message .= " - ". $notice->getText() . "\n";
            }
        }

        echo $message;

        return $this;
    }

    private function getCurrentTimestamp(): float
    {
        return microtime(true);
    }

    private function skipStartIfNecessary(): bool
    {
        if ($this->startTimestamp) {
            $this->notices->addNotice(new StartSkippedNotice());
            return true;
        }
        return false;
    }

    private function skipStopIfNecessary(): bool
    {
        if ($this->stopTimestamp) {
            $this->notices->addNotice(new StopSkippedNotice());
            return true;
        }
        return false;
    }

    /**
     * @return void
     */
    private function correctStartTimestampIfNecessary()
    {
        if (!$this->startTimestamp) {
            $this->notices->addNotice(new StartMissedNotice());
            $this->startTimestamp = $this->createTimestamp;
        }
    }

    /**
     * @return void
     */
    private function correctStopTimestampIfNecessary()
    {
        if (!$this->stopTimestamp) {
            $this->notices->addNotice(new StopMissedNotice());
            $this->stopTimestamp = $this->reportTimestamp;
        }
    }


}