<?php

declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use Almasmurad\Stopwatch\Report\Common\ReportInterface;
use Almasmurad\Stopwatch\Report\Renderer\Common\ReportRendererInterface;

// Declare new renderer class
class OneLineReportRenderer implements ReportRendererInterface
{
    public function render(ReportInterface $report): string
    {
        $start = $report->getStartEvent()->getDateTime()->format('H:i:s');
        $duration = (int) $report->getAllTime()->getSeconds();

        return "Stopwatch started at {$start} and ran for {$duration} full seconds";
    }
}

// Create Stopwatch and start measuring
$stopwatch = new \Almasmurad\Stopwatch\Stopwatch();

// (measured code)
$html = file_get_contents('https://csszengarden.com/examples/index') ?: '';
preg_match_all('/\bhttps?:\/\/[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|\/))/i', $html, $match);
$urls = $match[0];

// Finish measuring, set new renderer and print report to standard output
$stopwatch->setReportRenderer(new OneLineReportRenderer())->report();
