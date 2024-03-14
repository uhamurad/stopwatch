<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch;

use Almasmurad\Stopwatch\Stopwatch;
use Almasmurad\Stopwatch\Stopwatch\ReportRoutes\InMemoryReportRoute;
use Almasmurad\Stopwatch\Tests\Stopwatch\Common\AbstractTest;
use org\bovigo\vfs\vfsStream;

class StopwatchTest extends AbstractTest
{
    /**
     * @return void
     */
    public function testGetReport()
    {
        // Given
        $stopwatch = new Stopwatch();

        // When
        list($beforeStartTimestamp, $afterStartTimestamp, $afterFinishTimestamp) = $this->simpleAct($stopwatch);
        $report = $stopwatch->getReport();

        // Then
        $this->assertGreaterThanOrEqual($beforeStartTimestamp, $report->getStartEvent()->getTimestamp());
        $this->assertLessThanOrEqual($afterStartTimestamp, $report->getStartEvent()->getTimestamp());

        $this->assertGreaterThanOrEqual($afterStartTimestamp, $report->getFinishEvent()->getTimestamp());
        $this->assertLessThanOrEqual($afterFinishTimestamp, $report->getFinishEvent()->getTimestamp());

        $this->assertGreaterThanOrEqual($afterFinishTimestamp - $beforeStartTimestamp, $report->getStartEvent()->getTimestamp());
    }

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
        $vfsStreamDirectory = vfsStream::setup();
        $filepath = $vfsStreamDirectory->url().'/report/report.txt';
        $stopwatch = new Stopwatch();

        // When
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
        $vfsStreamDirectory = vfsStream::setup();
        $filepath = $vfsStreamDirectory->url().'/report/';
        $stopwatch = new Stopwatch();

        // When
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
        $testReportRoute = new InMemoryReportRoute();
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
