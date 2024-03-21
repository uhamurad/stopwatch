<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Report\Sender;

use Almasmurad\Stopwatch\Report\Sender\Common\Exceptions\UnableToSendReportException;
use Almasmurad\Stopwatch\Report\Sender\Common\ReportSenderInterface;

final class FileReportSender implements ReportSenderInterface
{
    /**
     * @var string
     */
    private $filepath;

    public function __construct(string $filepath)
    {
        $this->filepath = $filepath;
    }

    /**
     * @inheritDoc
     */
    public function send(string $report)
    {
        $this->filePutContents($this->filepath, $report);
    }
    /**
     * @return void
     */
    private function filePutContents(string $fullPath, string $contents)
    {
        $parts = explode('/', $fullPath);
        array_pop($parts);
        $dir = implode('/', $parts);

        if(!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $result = @file_put_contents($fullPath, $contents);
        if ($result === false) {
            $error = error_get_last();
            throw new UnableToSendReportException($this, $contents, sprintf(
                "Error due calling file_put_contents() for writing a report: %s",
                $error['message'] ?? 'undefined error'
            ));
        }
    }
}
