<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Report\Route;

use Almasmurad\Stopwatch\Report\Route\Common\ReportRouteInterface;

final class StdoutReportRoute implements ReportRouteInterface
{
    /**
     * @inheritDoc
     */
    public function process(string $report)
    {
        echo $report;
    }
}
