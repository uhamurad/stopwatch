<?php

declare(strict_types=1);

use Almasmurad\Stopwatch\Report\Sender\Common\ReportSenderInterface;

require_once __DIR__ . '/../vendor/autoload.php';

// Declare new sender class
class SyslogReportSender implements ReportSenderInterface
{
    public function send(string $report)
    {
        openlog("stopwatch", LOG_PID, LOG_LOCAL0);
        syslog(LOG_INFO, $report);
        closelog();
    }
}

// Create Stopwatch with new sender and start measuring
$stopwatch = new \Almasmurad\Stopwatch\Stopwatch(new SyslogReportSender());

// (measured code)
$html = file_get_contents('https://csszengarden.com/examples/index') ?: '';
preg_match_all('/\bhttps?:\/\/[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|\/))/i', $html, $match);
$urls = $match[0];

// Finish measuring and send report to the syslog
$stopwatch->report();

// Let's check the syslog
system('tail /var/log/syslog 2>&1');
