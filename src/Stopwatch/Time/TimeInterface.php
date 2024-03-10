<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Time;

/**
 * Interface TimeInterface represents a measured time interval
 *
 * @api
 *
 * Note. We don't have a method like getDateInterval() that returns DateInterval, because DateInterval in PHP v7.0 doesn't support milliseconds
 */
interface TimeInterface
{
    public function getSeconds(): float;

    public function isMeasured(): bool;
}
