<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\State\Common;

/**
 * StateInterface defines the methods for managing state timestamps.
 */
interface StateInterface extends StateImmutableInterface
{
    /**
     * @return void
     */
    public function setStartTimestamp(float $timestamp);

    /**
     * @param float $timestamp
     * @return void
     */
    public function setFinishTimestamp(float $timestamp);
}
