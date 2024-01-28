<?php

namespace Almasmurad\Stopwatch\Stopwatch;

interface StopwatchInterface
{
    public function start(): self;

    public function stop(): self;

    public function report(): self;
}