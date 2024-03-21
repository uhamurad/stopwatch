<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\State\Common;

use Almasmurad\Stopwatch\Stopwatch\Event\Common\EventInterface;

/**
 * Interface StateInterface defines methods for retrieving various timestamps of a state.
 */
interface StateInterface
{
    public function getStartEvent(): EventInterface;

    public function getFinishEvent(): EventInterface;

    public function isComplete(): bool;
}
