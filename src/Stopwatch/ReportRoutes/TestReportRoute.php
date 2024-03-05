<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\ReportRoutes;

class TestReportRoute implements Common\ReportRouteInterface
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

    public function getReport(): string
    {
        return $this->report;
    }
}
