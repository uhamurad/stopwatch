<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\ReportRoutes;

class StdoutReportRoute implements Common\ReportRouteInterface
{
    /**
     * @inheritDoc
     */
    public function process(string $report)
    {
        echo $report;
    }
}
