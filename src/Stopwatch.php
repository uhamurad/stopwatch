<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch;

use Almasmurad\Stopwatch\Stopwatch\Notices\NoticesCollection;
use Almasmurad\Stopwatch\Stopwatch\Notices\StartSkippedNotice;
use Almasmurad\Stopwatch\Stopwatch\Notices\StopSkippedNotice;
use Almasmurad\Stopwatch\Stopwatch\Report\Factory\ReportFactory;
use Almasmurad\Stopwatch\Stopwatch\Report\ReportInterface;
use Almasmurad\Stopwatch\Stopwatch\ReportRoutes\Common\ReportRouteInterface;
use Almasmurad\Stopwatch\Stopwatch\ReportRoutes\FileReportRoute;
use Almasmurad\Stopwatch\Stopwatch\ReportRoutes\StdoutReportRoute;
use Almasmurad\Stopwatch\Stopwatch\State\State;
use Almasmurad\Stopwatch\Stopwatch\StopwatchInterface;

/**
 * Class Stopwatch represents a stopwatch that can be used to measure elapsed time.
 *
 * @api
 */
final class Stopwatch implements StopwatchInterface
{
    /**
     * @var float
     * @readonly
     */
    private $createTimestamp;

    /**
     * @var State
     * @readonly
     */
    private $state;

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
        $this->state = new State();
    }

    public function start(): StopwatchInterface
    {
        if (!$this->skipStartIfNecessary()) {
            $this->state->setStartTimestamp($this->getCurrentTimestamp());
        };
        return $this;
    }

    public function stop(): StopwatchInterface
    {
        if (!$this->skipStopIfNecessary()) {
            $this->state->setFinishTimestamp($this->getCurrentTimestamp());
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

    public function getReport(): ReportInterface
    {
        $factory = new ReportFactory();
        $report = $factory->createFromState($this->state);
        return $report;
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
        if ($this->state->isStartTimestampSet()) {
            $this->notices->addNotice(new StartSkippedNotice());
            return true;
        }
        return false;
    }

    private function skipStopIfNecessary(): bool
    {
        if ($this->state->isFinishTimestampSet()) {
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
        if (!$this->state->isStartTimestampSet()) {
            $this->state->setStartTimestamp($this->createTimestamp);
        }
    }

    /**
     * @return void
     */
    private function correctStopTimestampIfNecessary()
    {
        if (!$this->state->isFinishTimestampSet()) {
            $this->state->setFinishTimestamp($this->reportTimestamp);
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
        } catch (\Throwable $exception) { // @codeCoverageIgnore

        }
    }

    /**
     * @return string
     */
    private function makeReport(): string
    {
        $elapsed = $this->state->getFinishTimestamp() - $this->state->getStartTimestamp();

        $startedStr = date('r', (int)$this->state->getStartTimestamp());
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
