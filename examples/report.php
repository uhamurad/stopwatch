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

// Option 1. Print report to standard output
$stopwatch->report();

// Option 2. Output report to local file
$stopwatch->reportToFile(__DIR__ . '/report/report.txt');

// Option 3. Get report object and use its parameters
$report = $stopwatch->getReport();
$elapsed = $report->getAllTime()->getSeconds();
printf('Wow it spent %f seconds', $elapsed);
