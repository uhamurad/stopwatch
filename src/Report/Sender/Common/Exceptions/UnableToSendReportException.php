<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Report\Sender\Common\Exceptions;

use Almasmurad\Stopwatch\Common\Exceptions\StopwatchException;
use Almasmurad\Stopwatch\Report\Sender\Common\ReportSenderInterface;

final class UnableToSendReportException extends StopwatchException
{
    public function __construct(ReportSenderInterface $sender, string $report, string $message = "", int $code = 0, \Throwable $previous = null)
    {
        $message = sprintf('%s. Sender: %s, Report: %s', $message, get_class($sender), $report);
        parent::__construct($message, $code, $previous);
    }
}
