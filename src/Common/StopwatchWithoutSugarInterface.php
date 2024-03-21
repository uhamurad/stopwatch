<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Common;

use Almasmurad\Stopwatch\Report\Common\ReportInterface;

interface StopwatchWithoutSugarInterface
{
    /**
     * @return void
     */
    public function start();

    /**
     * @return void
     */
    public function finish();

    /**
     * @return void
     */
    public function report();

    public function getReport(): ReportInterface;
}
