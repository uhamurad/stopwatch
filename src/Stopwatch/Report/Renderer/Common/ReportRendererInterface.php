<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Report\Renderer\Common;

use Almasmurad\Stopwatch\Stopwatch\Report\Renderer\Exceptions\UnableToRenderReportException;
use Almasmurad\Stopwatch\Stopwatch\Report\ReportInterface;

/**
 * Interface ReportRendererInterface represents service that renders Report object to text
 */
interface ReportRendererInterface
{
    /**
     * @param ReportInterface $report
     * @throws UnableToRenderReportException
     */
    public function render(ReportInterface $report): string;
}
