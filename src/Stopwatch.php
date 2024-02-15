<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch;

use Almasmurad\Stopwatch\Stopwatch\Notices\NoticesCollection;
use Almasmurad\Stopwatch\Stopwatch\Notices\StartSkippedNotice;
use Almasmurad\Stopwatch\Stopwatch\Notices\StopSkippedNotice;
use Almasmurad\Stopwatch\Stopwatch\ReportRoutes\Common\ReportRouteInterface;
use Almasmurad\Stopwatch\Stopwatch\ReportRoutes\FileReportRoute;
use Almasmurad\Stopwatch\Stopwatch\ReportRoutes\StdoutReportRoute;
use Almasmurad\Stopwatch\Stopwatch\StopwatchInterface;

final class Stopwatch implements StopwatchInterface
{
    /**
     * @var float
     * @readonly
     */
    private $createTimestamp;
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
     * @readonly
     */
    private $notices;

    /**
     * @var ReportRouteInterface
     */
    private $reportRoute;

    public function __construct()
    {
        $this->createTimestamp = $this->getCurrentTimestamp();
        $this->notices = new NoticesCollection();
        $this->reportRoute = $this->getDefaultReportRoute();
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

        $message = $this->makeReport();

        $this->processReport($message);

        return $this;
    }

    public function reportToFile(string $filepath): StopwatchInterface
    {
        return $this->withReportRoute(new FileReportRoute($filepath))->report();
    }

    public function withReportRoute(ReportRouteInterface $reportRoute): StopwatchInterface
    {
        $clone = clone $this;
        $clone->reportRoute = $reportRoute;
        return $clone;
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
            $this->startTimestamp = $this->createTimestamp;
        }
    }

    /**
     * @return void
     */
    private function correctStopTimestampIfNecessary()
    {
        if (!$this->stopTimestamp) {
            $this->stopTimestamp = $this->reportTimestamp;
        }
    }

    private function getDefaultReportRoute(): ReportRouteInterface
    {
        return new StdoutReportRoute();
    }

    /**
     * @param string $message
     * @return void
     */
    private function processReport(string $message)
    {
        try {
            $this->reportRoute->process($message);
        } catch (\Throwable $exception) {

        }
    }

    /**
     * @return string
     */
    private function makeReport(): string
    {
        $elapsed = $this->stopTimestamp - $this->startTimestamp;

        $startedStr = date('r', (int)$this->startTimestamp);
        $elapsedStr = number_format($elapsed, 3, '.', ' ');

        $message = "Started at {$startedStr}\n";
        $breakLineLength = mb_strlen($message);
        $breakLine = str_repeat('—', $breakLineLength) . "\n";
        $message .= $breakLine;
        $message .= "All time | {$elapsedStr}s\n";

        if ($this->notices->hasNotices()) {
            $message .= $breakLine;
            $message .= "Notices:\n";
            foreach ($this->notices->getAllNotices() as $notice) {
                $message .= " - " . $notice->getText() . "\n";
            }
        }
        return $message;
    }

}
