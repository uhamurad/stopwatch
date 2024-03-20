<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\ReportRoutes\Common;

interface ReportRouteInterface
{
    /**
     * @return void
     */
    public function process(string $report);
}
