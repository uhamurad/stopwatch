<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Report\Renderer;

use Almasmurad\Stopwatch\Report\Common\ReportInterface;
use Almasmurad\Stopwatch\Report\Renderer\Common\ReportRendererInterface;

/**
 * Class BasicReportRenderer provides a basic implementation for rendering a report.
 */
final class BasicReportRenderer implements ReportRendererInterface
{
    public function render(ReportInterface $report): string
    {
        $startTimestamp = $report->getStartEvent()->getTimestamp();
        $startHappened = $report->getStartEvent()->isHappened();
        $allSeconds = $report->getAllTime()->getSeconds();
        $allSecondsMeasured = $report->getAllTime()->isMeasured();

        $elapsedStr = $allSecondsMeasured ? number_format($allSeconds, 3, '.', ' ') . 's' : '[unknown]';

        $startedStr = $startHappened ? date('r', (int) $startTimestamp) : '[unknown]';

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
