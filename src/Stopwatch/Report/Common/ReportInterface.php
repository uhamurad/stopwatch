<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Report\Common;

use Almasmurad\Stopwatch\Stopwatch\Event\Common\EventInterface;
use Almasmurad\Stopwatch\Stopwatch\Report\non;
use Almasmurad\Stopwatch\Stopwatch\Time\Common\TimeInterface;

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

    /**
     * @return non-empty-string[]
     */
    public function getNotices(): array;

    public function hasNotices(): bool;
}
