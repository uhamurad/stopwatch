<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Report\Route;

use Almasmurad\Stopwatch\Stopwatch\Report\Route\Common\ReportRouteInterface;

final class InMemoryReportRoute implements ReportRouteInterface
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
