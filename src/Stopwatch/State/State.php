<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\State;

use Almasmurad\Stopwatch\Stopwatch\Event\Common\EventInterface;
use Almasmurad\Stopwatch\Stopwatch\Event\Event;
use Almasmurad\Stopwatch\Stopwatch\State\Common\StateInterface;

/**
 * The State class represents the state of stopwatch
 *
 * @internal
 */
final class State implements StateInterface
{
    /**
     * @var Event
     */
    private $startEvent;
    /**
     * @var Event
     */
    private $finishEvent;


    public function __construct()
    {
        $this->startEvent = Event::createNonHappened();
        $this->finishEvent = Event::createNonHappened();
    }

    /**
     * @return void
     */
    public function setStartTimestamp(float $timestamp)
    {
        $this->startEvent = Event::createHappened($timestamp);
    }

    /**
     * @return void
     */
    public function setFinishTimestamp(float $timestamp)
    {
        $this->finishEvent = Event::createHappened($timestamp);
    }

    public function isComplete(): bool
    {
        return $this->startEvent->isHappened() && $this->finishEvent->isHappened();
    }

    public function getStartEvent(): EventInterface
    {
        return $this->startEvent;
    }

    public function getFinishEvent(): EventInterface
    {
        return $this->finishEvent;
    }
}
