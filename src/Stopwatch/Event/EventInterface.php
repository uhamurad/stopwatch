<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Event;

/**
 * Interface EventInterface represents stopwatch events such as start and stop measuring
 *
 * @api
 */
interface EventInterface
{
    public function getDateTime(): \DateTimeInterface;

    public function getTimestamp(): float;

    public function isHappened(): bool;
}