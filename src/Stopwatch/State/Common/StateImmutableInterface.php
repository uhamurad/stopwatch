<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\State\Common;

/**
 * Interface StateImmutableInterface defines methods for retrieving various timestamps of a state.
 */
interface StateImmutableInterface
{
    public function getStartTimestamp(): float;

    public function isStartTimestampSet(): bool;

    public function getFinishTimestamp(): float;

    public function isFinishTimestampSet(): bool;
}
