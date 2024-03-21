<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Common;

use Almasmurad\Stopwatch\Report\Renderer\Common\ReportRendererInterface;
use Almasmurad\Stopwatch\Report\Sender\Common\ReportSenderInterface;

interface StopwatchInterface extends StopwatchWithoutSugarInterface
{
    /**
     * @return void
     */
    public function reportToFile(string $filepath);

    public function setReportSender(ReportSenderInterface $reportSender): self;

    public function setReportRenderer(ReportRendererInterface $reportRenderer): self;
}
