<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Report\Sender\Common;

interface ReportSenderInterface
{
    /**
     * @return void
     */
    public function send(string $report);
}
