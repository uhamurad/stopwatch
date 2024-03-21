<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Common;

use Almasmurad\Stopwatch\Stopwatch\Report\Renderer\Common\ReportRendererInterface;
use Almasmurad\Stopwatch\Stopwatch\Report\Route\Common\ReportRouteInterface;

interface StopwatchInterface extends StopwatchWithoutSugarInterface
{
    /**
     * @return void
     */
    public function reportToFile(string $filepath);

    public function setReportRoute(ReportRouteInterface $reportRoute): self;

    public function setReportRenderer(ReportRendererInterface $reportRenderer): self;
}
