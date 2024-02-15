<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch;

use Almasmurad\Stopwatch\Stopwatch\ReportRoutes\Common\ReportRouteInterface;

interface StopwatchInterface extends StopwatchWithoutSugarInterface
{
    public function reportToFile(string $filepath): self;

    public function withReportRoute(ReportRouteInterface $reportRoute): self;
}
