<?php

declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';

// Create Stopwatch and start measuring
$stopwatch = new \Almasmurad\Stopwatch\Stopwatch();

// (measured code)
$html = file_get_contents('https://csszengarden.com/examples/index') ?: '';
preg_match_all('/\bhttps?:\/\/[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|\/))/i', $html, $match);
$urls = $match[0];

// Finish measuring
$stopwatch->finish();

// !!! Error - repeated calling the finish() method
$stopwatch->finish();

// Getting notice
$report = $stopwatch->getReport();
$notices = $report->getNotices();

foreach ($notices as $notice) {
    printf("Pay attention to the notice: %s\n", $notice);
}
