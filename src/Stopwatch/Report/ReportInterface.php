<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Report;

use Almasmurad\Stopwatch\Stopwatch\Event\EventInterface;
use Almasmurad\Stopwatch\Stopwatch\Time\TimeInterface;

/**
 * ReportInterface represents a Stopwatch running report.
 *
 * @api
 */
interface ReportInterface
{
    public function getStartEvent(): EventInterface;

    public function getFinishEvent(): EventInterface;

    public function getAllTime(): TimeInterface;
}
