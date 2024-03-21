<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Report\Sender;

use Almasmurad\Stopwatch\Report\Sender\Common\ReportSenderInterface;

final class StdoutReportSender implements ReportSenderInterface
{
    /**
     * @inheritDoc
     */
    public function send(string $report)
    {
        echo $report;
    }
}
