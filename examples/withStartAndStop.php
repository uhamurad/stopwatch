<?php

declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

// Create Stopwatch
$stopwatch = new \Almasmurad\Stopwatch\Stopwatch();

$html = file_get_contents('https://csszengarden.com/examples/index') ?: '';

// Start measuring
$stopwatch->start();

// (measured code)
preg_match_all('/\bhttps?:\/\/[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|\/))/i', $html, $match);

// Finish measuring
$stopwatch->finish();

$urls = $match[0];

// Output report
$stopwatch->report();
