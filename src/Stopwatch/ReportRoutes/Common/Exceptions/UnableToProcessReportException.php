<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\ReportRoutes\Common\Exceptions;

use Almasmurad\Stopwatch\Stopwatch\Exceptions\StopwatchException;
use Almasmurad\Stopwatch\Stopwatch\ReportRoutes\Common\ReportRouteInterface;

class UnableToProcessReportException extends StopwatchException
{
    /**
     * @var ReportRouteInterface
     */
    private $route;
    /**
     * @var string
     */
    private $report;
    public function __construct(ReportRouteInterface $route, string $report, string $message = "", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->route = $route;
        $this->report = $report;
    }

    public function getRoute(): ReportRouteInterface
    {
        return $this->route;
    }

    public function getReport(): string
    {
        return $this->report;
    }
}
