<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch;

use Almasmurad\Stopwatch\Stopwatch;
use Almasmurad\Stopwatch\Tests\Stopwatch\Common\AbstractTest;

class ReportToFileTest extends AbstractTest
{
    /**
     * @return void
     */
    public function testOk()
    {
        // arrange
        $stopwatch = new Stopwatch();
        $filepath = $this->makeTmpFile();

        // act
        list($beforeStartTimestamp, $afterStartTimestamp) = $this->simpleAct($stopwatch);
        $stopwatch->reportToFile($filepath);
        $report = file_get_contents($filepath) ?: '';

        // assert
        $this->assertStartedAtLabel($report);
        $this->assertStartedAtValue($report, $beforeStartTimestamp, $afterStartTimestamp);

    }


    protected function makeTmpFile(): string
    {
        $filename = tempnam(sys_get_temp_dir(), 'test') ?: '';
        if (!$filename) {
            throw new \RuntimeException('Error due creating temp file');
        }
        return $filename;
    }


}
