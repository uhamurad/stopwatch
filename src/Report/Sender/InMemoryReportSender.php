<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Report\Sender;

use Almasmurad\Stopwatch\Report\Sender\Common\ReportSenderInterface;

final class InMemoryReportSender implements ReportSenderInterface
{
    /**
     * @var string
     */
    private $report = '';

    /**
     * @inheritDoc
     */
    public function send(string $report)
    {
        $this->report = $report;
    }

    public function getRenderedReport(): string
    {
        return $this->report;
    }
}
