<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Report\Route\Common;

interface ReportRouteInterface
{
    /**
     * @return void
     */
    public function process(string $report);
}
