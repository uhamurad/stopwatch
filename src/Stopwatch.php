<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch;

use Almasmurad\Stopwatch\Stopwatch\Notices\NoticesCollection;
use Almasmurad\Stopwatch\Stopwatch\Notices\StartSkippedNotice;
use Almasmurad\Stopwatch\Stopwatch\Notices\StopSkippedNotice;
use Almasmurad\Stopwatch\Stopwatch\Report\Factory\ReportFactory;
use Almasmurad\Stopwatch\Stopwatch\Report\Renderer\BasicReportRenderer;
use Almasmurad\Stopwatch\Stopwatch\Report\Renderer\Common\ReportRendererInterface;
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

    /**
     * @var ReportRendererInterface
     */
    private $reportRenderer;

    public function __construct()
    {
        $this->createTimestamp = $this->getCurrentTimestamp();
        $this->notices = new NoticesCollection();
        $this->reportRoute = $this->getDefaultReportRoute();
        $this->reportRenderer = $this->getDefaultReportRenderer();
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
        $report = $this->getReport();
        $reportText = $this->renderReport($report);
        $this->routeRenderedReport($reportText);

        return $this;
    }

    public function getReport(): ReportInterface
    {
        $this->handleReportCalling();

        $factory = new ReportFactory();
        return $factory->create($this->state, $this->notices);
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

    public function withReportRenderer(ReportRendererInterface $reportRenderer): StopwatchInterface
    {
        $clone = clone $this;
        $clone->reportRenderer = $reportRenderer;
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

    private function getDefaultReportRenderer(): ReportRendererInterface
    {
        return new BasicReportRenderer();
    }

    /**
     * @param string $renderedReport
     * @return void
     */
    private function routeRenderedReport(string $renderedReport)
    {
        try {
            $this->reportRoute->process($renderedReport);
        } catch (\Throwable $exception) { // @codeCoverageIgnore

        }
    }

    private function renderReport(ReportInterface $report): string
    {
        try {
            return $this->reportRenderer->render($report);
        } catch (\Throwable $exception) {
            return sprintf('Error due report rendering: %s. Occurred as %s', $exception->getMessage(), date('r'));
        }
    }

    /**
     * @return void
     */
    private function handleReportCalling()
    {
        if (!$this->reportTimestamp) {
            $this->reportTimestamp = $this->getCurrentTimestamp();
        }

        $this->correctStartTimestampIfNecessary();
        $this->correctStopTimestampIfNecessary();
    }


}
