<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch;

use Almasmurad\Stopwatch\Common\StopwatchInterface;
use Almasmurad\Stopwatch\Notice\Collection\NoticesCollection;
use Almasmurad\Stopwatch\Notice\FinishSkippedNotice;
use Almasmurad\Stopwatch\Notice\StartSkippedNotice;
use Almasmurad\Stopwatch\Report\Common\ReportInterface;
use Almasmurad\Stopwatch\Report\Factory\ReportFactory;
use Almasmurad\Stopwatch\Report\Renderer\BasicReportRenderer;
use Almasmurad\Stopwatch\Report\Renderer\Common\ReportRendererInterface;
use Almasmurad\Stopwatch\Report\Sender\Common\ReportSenderInterface;
use Almasmurad\Stopwatch\Report\Sender\FileReportSender;
use Almasmurad\Stopwatch\Report\Sender\StdoutReportSender;
use Almasmurad\Stopwatch\State\State;

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
     * @var ReportSenderInterface
     */
    private $reportSender;

    /**
     * @var ReportRendererInterface
     */
    private $reportRenderer;

    public function __construct(
        ReportSenderInterface $reportSender = null,
        ReportRendererInterface $reportRenderer = null
    ) {
        $this->createTimestamp = $this->getCurrentTimestamp();
        $this->notices = new NoticesCollection();
        $this->reportSender = $reportSender ?? $this->getDefaultReportSender();
        $this->reportRenderer = $reportRenderer ?? $this->getDefaultReportRenderer();
        $this->state = new State();
    }

    public function start()
    {
        if (!$this->skipStartIfNecessary()) {
            $this->state->setStartTimestamp($this->getCurrentTimestamp());
        }
    }

    public function finish()
    {
        if (!$this->skipFinishIfNecessary()) {
            $this->state->setFinishTimestamp($this->getCurrentTimestamp());
            $this->correctStartTimestampIfNecessary();
        }
    }

    public function report()
    {
        $report = $this->getReport();
        $reportText = $this->renderReport($report);
        $this->sendRenderedReport($reportText);
    }

    public function reportToFile(string $filepath)
    {
        $this->setReportSender(new FileReportSender($filepath))->report();
    }

    public function getReport(): ReportInterface
    {
        $this->handleReportCalling();

        $factory = new ReportFactory();
        return $factory->create($this->state, $this->notices);
    }

    public function setReportSender(ReportSenderInterface $reportSender): StopwatchInterface
    {
        $this->reportSender = $reportSender;
        return $this;
    }

    public function setReportRenderer(ReportRendererInterface $reportRenderer): StopwatchInterface
    {
        $this->reportRenderer = $reportRenderer;
        return $this;
    }

    private function getCurrentTimestamp(): float
    {
        return microtime(true);
    }

    private function skipStartIfNecessary(): bool
    {
        $state = $this->state;
        if ($state->getStartEvent()->isHappened()) {
            $this->notices->addNotice(new StartSkippedNotice());
            return true;
        }
        return false;
    }

    private function skipFinishIfNecessary(): bool
    {
        $state = $this->state;
        if ($state->getFinishEvent()->isHappened()) {
            $this->notices->addNotice(new FinishSkippedNotice());
            return true;
        }
        return false;
    }

    /**
     * @return void
     */
    private function correctStartTimestampIfNecessary()
    {
        $state = $this->state;
        if (!$state->getStartEvent()->isHappened()) {
            $this->state->setStartTimestamp($this->createTimestamp);
        }
    }

    /**
     * @return void
     */
    private function correctFinishTimestampIfNecessary()
    {
        $state = $this->state;
        if (!$state->getFinishEvent()->isHappened()) {
            $this->state->setFinishTimestamp($this->reportTimestamp);
        }
    }

    private function getDefaultReportSender(): ReportSenderInterface
    {
        return new StdoutReportSender();
    }

    private function getDefaultReportRenderer(): ReportRendererInterface
    {
        return new BasicReportRenderer();
    }

    /**
     * @return void
     */
    private function sendRenderedReport(string $renderedReport)
    {
        try {
            $this->reportSender->send($renderedReport);
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
        $this->correctFinishTimestampIfNecessary();
    }


}
