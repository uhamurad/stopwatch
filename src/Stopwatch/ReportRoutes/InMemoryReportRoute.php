<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\ReportRoutes;

use Almasmurad\Stopwatch\Stopwatch\ReportRoutes\Common\ReportRouteInterface;

class InMemoryReportRoute implements ReportRouteInterface
{
    /**
     * @var string
     */
    private $report = '';

    /**
     * @inheritDoc
     */
    public function process(string $report)
    {
        $this->report = $report;
    }

    public function getRenderedReport(): string
    {
        return $this->report;
    }
}
