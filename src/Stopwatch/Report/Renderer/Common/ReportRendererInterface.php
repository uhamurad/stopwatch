<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Report\Renderer\Common;

use Almasmurad\Stopwatch\Stopwatch\Report\Common\ReportInterface;
use Almasmurad\Stopwatch\Stopwatch\Report\Renderer\Common\Exceptions\UnableToRenderReportException;

/**
 * Interface ReportRendererInterface represents service that renders Report object to text
 */
interface ReportRendererInterface
{
    /**
     * @throws UnableToRenderReportException
     */
    public function render(ReportInterface $report): string;
}
