<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\ReportRoutes;

use Almasmurad\Stopwatch\Stopwatch\ReportRoutes\Common\ReportRouteInterface;

class StdoutReportRoute implements ReportRouteInterface
{
    /**
     * @inheritDoc
     */
    public function process(string $report)
    {
        echo $report;
    }
}
