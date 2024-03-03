<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch;

use Almasmurad\Stopwatch\Stopwatch;
use Almasmurad\Stopwatch\Tests\Stopwatch\Common\AbstractTest;

class StopwatchTest extends AbstractTest
{
    /**
     * @return void
     */
    public function testReport()
    {
        // Given
        $stopwatch = new Stopwatch();

        // When
        $this->setOutputCallback(function () {});
        $beforeStartTimestamp = microtime(true);
        $stopwatch->start();
        $afterStartTimestamp = microtime(true);
        $stopwatch->stop();
        $stopwatch->report();

        // Then
        $output = $this->getActualOutput();
        $this->assertStartedAtLabel($output);
        $this->assertStartedAtValue($output, $beforeStartTimestamp, $afterStartTimestamp);
    }

    /**
     * @return void
     */
    public function testReportToFile()
    {
        // Given
        $dir = __DIR__.'/runtime/report';
        $filepath = $dir.'/report.txt';
        $stopwatch = new Stopwatch();

        // When
        @rmdir($dir);
        @unlink($filepath);
        $beforeStartTimestamp = microtime(true);
        $stopwatch->start();
        $afterStartTimestamp = microtime(true);
        $stopwatch->stop();
        $stopwatch->reportToFile($filepath);

        // Then
        $output = file_get_contents($filepath) ?: '';
        $this->assertStartedAtLabel($output);
        $this->assertStartedAtValue($output, $beforeStartTimestamp, $afterStartTimestamp);
    }

    /**
     * @doesNotPerformAssertions
     * @return void
     */
    public function testReportWhenRouteThrowsException()
    {
        // Given
        $dir = __DIR__.'/runtime/report';
        $filepath = $dir.'/';
        $stopwatch = new Stopwatch();

        // When
        @rmdir($dir);
        $beforeStartTimestamp = microtime(true);
        $stopwatch->start();
        $afterStartTimestamp = microtime(true);
        $stopwatch->stop();
        $stopwatch->reportToFile($filepath);

        // Then no exceptions
    }

}
