<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch;

use Almasmurad\Stopwatch\Stopwatch;
use Almasmurad\Stopwatch\Stopwatch\ReportRoutes\TestReportRoute;
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
        list($beforeStartTimestamp, $afterStartTimestamp) = $this->simpleAct($stopwatch);
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
        list($beforeStartTimestamp, $afterStartTimestamp) = $this->simpleAct($stopwatch);
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
        $this->simpleAct($stopwatch);
        $stopwatch->reportToFile($filepath);

        // Then no exceptions
    }

    /**
     * @return void
     */
    public function testWithReportRoute()
    {
        // Given
        $testReportRoute = new TestReportRoute();
        $stopwatch = (new Stopwatch())->withReportRoute($testReportRoute);

        // When
        list($beforeStartTimestamp, $afterStartTimestamp) = $this->simpleAct($stopwatch);
        $stopwatch->report();

        // Then
        $output = $testReportRoute->getReport();
        $this->assertStartedAtLabel($output);
        $this->assertStartedAtValue($output, $beforeStartTimestamp, $afterStartTimestamp);
    }

}
