<?php

declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';

// Create Stopwatch and start measuring
$stopwatch = new \Almasmurad\Stopwatch\Stopwatch();

// (measured code)
$html = file_get_contents('https://csszengarden.com/examples/index') ?: '';
preg_match_all('/\bhttps?:\/\/[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|\/))/i', $html, $match);
$urls = $match[0];

// Option 1. Finish measuring and print report to standard output
$stopwatch->report();

// Option 2. Finish measuring and output report to local file
$stopwatch->reportToFile(__DIR__ . '/runtime/report.txt');

// Option 3. Finish measuring and get report object and use its parameters
$report = $stopwatch->getReport();
$elapsed = $report->getAllTime()->getSeconds();
printf('Wow it spent %f seconds', $elapsed);
