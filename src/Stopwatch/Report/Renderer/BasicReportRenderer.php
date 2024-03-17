<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Report\Renderer;

use Almasmurad\Stopwatch\Stopwatch\Report\Renderer\Common\ReportRendererInterface;
use Almasmurad\Stopwatch\Stopwatch\Report\ReportInterface;

class BasicReportRenderer implements ReportRendererInterface
{
    public function render(ReportInterface $report): string
    {
        $startTime = $report->getStartEvent()->getTimestamp();
        $startHappened = $report->getStartEvent()->isHappened();
        $finishTime = $report->getFinishEvent()->getTimestamp();
        $finishHappened = $report->getFinishEvent()->isHappened();
        $allSeconds = $report->getAllTime()->getSeconds();
        $allSecondsMeasured = $report->getAllTime()->isMeasured();

        if ($allSecondsMeasured) {
            $elapsedStr = number_format($allSeconds, 3, '.', ' ').'s';
        } else {
            $elapsedStr = '[unknown]';
        }

        if ($startHappened) {
            $startedStr = date('r', (int)$startTime);
        } else {
            $startedStr = '[unknown]';
        }

        $message = "Started at {$startedStr}";
        $breakLineLength = 42;
        $breakLine = str_repeat('—', $breakLineLength);

        $message .= "\n".$breakLine;
        $message .= "\nAll time | {$elapsedStr}";

        if (count($notices = $report->getNotices()) > 0) {
            $message .= "\n".$breakLine;
            $message .= "\nNotices:";
            foreach ($notices as $notice) {
                $message .= "\n - " . $notice;
            }
        }
        return $message;
    }
}
