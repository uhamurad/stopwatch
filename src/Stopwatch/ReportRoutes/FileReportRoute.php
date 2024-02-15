<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\ReportRoutes;

use Almasmurad\Stopwatch\Stopwatch\ReportRoutes\Common\Exceptions\UnableToProcessReportException;

class FileReportRoute implements Common\ReportRouteInterface
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
    public function process(string $report)
    {
        $result = $this->filePutContents($this->filepath, $report);
        if ($result === false) {
            throw new UnableToProcessReportException($this, $report, sprintf('Unable to write report to file %s', $this->filepath));
        }
    }
    /**
     * @return false|int
     */
    private function filePutContents(string $fullPath, string $contents, int $flags = 0)
    {
        $parts = explode('/', $fullPath);
        array_pop($parts);
        $dir = implode('/', $parts);

        if(!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return file_put_contents($fullPath, $contents, $flags);
    }
}
