<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\ReportRoutes;

class InMemoryReportRoute implements Common\ReportRouteInterface
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
