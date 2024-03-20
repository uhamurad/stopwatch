<?php

declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';

// Create Stopwatch and start measuring
$stopwatch = new Almasmurad\Stopwatch\Stopwatch();

// (measured code)
$html = file_get_contents('https://csszengarden.com/examples/index') ?: '';
preg_match_all('/\bhttps?:\/\/[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|\/))/i', $html, $match);
$urls = $match[0];

// Finish measuring and output report
$stopwatch->report();
