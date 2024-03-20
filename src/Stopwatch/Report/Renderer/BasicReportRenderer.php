<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Report\Renderer;

use Almasmurad\Stopwatch\Stopwatch\Report\Renderer\Common\ReportRendererInterface;
use Almasmurad\Stopwatch\Stopwatch\Report\ReportInterface;

/**
 * Class BasicReportRenderer provides a basic implementation for rendering a report.
 */
final class BasicReportRenderer implements ReportRendererInterface
{
    public function render(ReportInterface $report): string
    {
        $startTime = $report->getStartEvent()->getTimestamp();
        $startHappened = $report->getStartEvent()->isHappened();
        $allSeconds = $report->getAllTime()->getSeconds();
        $allSecondsMeasured = $report->getAllTime()->isMeasured();

        $elapsedStr = $allSecondsMeasured ? number_format($allSeconds, 3, '.', ' ') . 's' : '[unknown]';

        $startedStr = $startHappened ? date('r', (int) $startTime) : '[unknown]';

        $message = "Started at {$startedStr}";
        $breakLineLength = 42;
        $breakLine = str_repeat('—', $breakLineLength);

        $message .= "\n" . $breakLine;
        $message .= "\nAll time | {$elapsedStr}";

        if (($notices = $report->getNotices()) !== []) {
            $message .= "\n" . $breakLine;
            $message .= "\nNotices:";
            foreach ($notices as $notice) {
                $message .= "\n - " . $notice;
            }
        }
        return $message;
    }
}
