<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Report\Renderer\Exceptions;

use Almasmurad\Stopwatch\Stopwatch\Exceptions\StopwatchException;
use Almasmurad\Stopwatch\Stopwatch\ReportRoutes\Common\ReportRouteInterface;

class UnableToRenderReportException extends StopwatchException
{
    public function __construct(ReportRouteInterface $route, string $report, string $message = "", int $code = 0, \Throwable $previous = null)
    {
        $message = sprintf('%s. Route: %s, Report: %s', $message, get_class($route), $report);
        parent::__construct($message, $code, $previous);
    }
}
