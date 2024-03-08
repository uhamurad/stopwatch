<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\State;

/**
 * The State class represents the state of stopwatch
 *
 * @internal
 */
final class State implements Common\StateInterface
{
    /**
     * @var float
     */
    private $startTimestamp = 0.0;

    /**
     * @var float
     */
    private $finishTimestamp = 0.0;

    public function getStartTimestamp(): float
    {
        return $this->startTimestamp;
    }

    public function getFinishTimestamp(): float
    {
        return $this->finishTimestamp;
    }

    public function setStartTimestamp(float $timestamp)
    {
        $this->startTimestamp = $timestamp;
    }

    public function setFinishTimestamp(float $timestamp)
    {
        $this->finishTimestamp = $timestamp;
    }

    public function isStartTimestampSet(): bool
    {
        return $this->startTimestamp !== 0.0;
    }

    public function isFinishTimestampSet(): bool
    {
        return $this->finishTimestamp !== 0.0;
    }
}
