<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Report\Renderer\Common;

use Almasmurad\Stopwatch\Report\Common\ReportInterface;
use Almasmurad\Stopwatch\Report\Renderer\Common\Exceptions\UnableToRenderReportException;

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
