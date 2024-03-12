<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\State;

use Almasmurad\Stopwatch\Stopwatch\State\Common\StateInterface;

/**
 * The State class represents the state of stopwatch
 *
 * @internal
 */
final class State implements StateInterface
{
    const NULL_TIMESTAMP = -1.0;

    /**
     * @var float
     */
    private $startTimestamp = self::NULL_TIMESTAMP;

    /**
     * @var float
     */
    private $finishTimestamp = self::NULL_TIMESTAMP;

    public function getStartTimestamp(): float
    {
        return $this->startTimestamp;
    }

    public function getFinishTimestamp(): float
    {
        return $this->finishTimestamp;
    }

    /**
     * @return void
     */
    public function setStartTimestamp(float $timestamp)
    {
        $this->startTimestamp = $timestamp;
    }

    /**
     * @return void
     */
    public function setFinishTimestamp(float $timestamp)
    {
        $this->finishTimestamp = $timestamp;
    }

    public function isStartTimestampSet(): bool
    {
        return $this->startTimestamp !== self::NULL_TIMESTAMP;
    }

    public function isFinishTimestampSet(): bool
    {
        return $this->finishTimestamp !== self::NULL_TIMESTAMP;
    }

    public function isComplete(): bool
    {
        return $this->isStartTimestampSet() && $this->isFinishTimestampSet();
    }
}
