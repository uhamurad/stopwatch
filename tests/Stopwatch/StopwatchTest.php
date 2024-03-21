<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch;

use Almasmurad\Stopwatch\Report\Renderer\BasicReportRenderer;
use Almasmurad\Stopwatch\Report\Renderer\ThrowingExceptionReportRenderer;
use Almasmurad\Stopwatch\Report\Route\InMemoryReportRoute;
use Almasmurad\Stopwatch\Stopwatch;
use Almasmurad\Stopwatch\Tests\Stopwatch\Common\AbstractTest;
use org\bovigo\vfs\vfsStream;

final class StopwatchTest extends AbstractTest
{
    /**
     * @return void
     */
    public function testGetReportWhenNoNotices()
    {
        // Given
        $stopwatch = new Stopwatch();

        // When
        list($beforeStartTimestamp, $afterStartTimestamp, $afterFinishTimestamp) = $this->simpleAct($stopwatch);
        $report = $stopwatch->getReport();

        // Then events and times
        $this->assertGreaterThanOrEqual($beforeStartTimestamp, $report->getStartEvent()->getTimestamp());
        $this->assertLessThanOrEqual($afterStartTimestamp, $report->getStartEvent()->getTimestamp());

        $this->assertGreaterThanOrEqual($afterStartTimestamp, $report->getFinishEvent()->getTimestamp());
        $this->assertLessThanOrEqual($afterFinishTimestamp, $report->getFinishEvent()->getTimestamp());

        $this->assertGreaterThanOrEqual($afterFinishTimestamp - $beforeStartTimestamp, $report->getStartEvent()->getTimestamp());

        // Then notices
        $this->assertFalse($report->hasNotices());
        $this->assertEmpty($report->getNotices());
    }

    /**
     * @return void
     */
    public function testGetReportWhenHasNotices()
    {
        // Given
        $stopwatch = new Stopwatch();

        // When
        list($beforeStartTimestamp, $afterStartTimestamp, $afterFinishTimestamp) = $this->simpleAct($stopwatch);
        $stopwatch->start();
        $report = $stopwatch->getReport();

        // Then
        $this->assertTrue($report->hasNotices());
        $this->assertArrayHasKey(0, $report->getNotices());
        $this->assertEquals('start() method calling was skipped, because Stopwatch is already started', $report->getNotices()[0]);
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
    public function testReportWhenReportRenderingErrorOccurred()
    {
        // Given
        $route = new InMemoryReportRoute();
        $renderer = new ThrowingExceptionReportRenderer();
        $stopwatch = (new Stopwatch())->setReportRoute($route);

        // When
        $stopwatch = $stopwatch->setReportRenderer($renderer);
        list($beforeStartTimestamp, $afterStartTimestamp) = $this->simpleAct($stopwatch);

        // Then
        $stopwatch->report();
        $renderedReport = $route->getRenderedReport();
        $this->assertContains('Error due report rendering', $renderedReport);
    }

    /**
     * @return void
     */
    public function testReportToFile()
    {
        // Given
        $vfsStreamDirectory = vfsStream::setup();
        $filepath = $vfsStreamDirectory->url() . '/report/report.txt';
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
        $filepath = $vfsStreamDirectory->url() . '/report/';
        $stopwatch = new Stopwatch();

        // When
        $this->simpleAct($stopwatch);
        $stopwatch->reportToFile($filepath);

        // Then no exceptions
    }

    /**
     * @return void
     */
    public function testSetReportRoute()
    {
        // Given
        $testReportRoute = new InMemoryReportRoute();
        $stopwatch = new Stopwatch();

        // When
        $stopwatch = $stopwatch->setReportRoute($testReportRoute);
        list($beforeStartTimestamp, $afterStartTimestamp) = $this->simpleAct($stopwatch);
        $stopwatch->report();

        // Then
        $output = $testReportRoute->getRenderedReport();
        $this->assertStartedAtLabel($output);
        $this->assertStartedAtValue($output, $beforeStartTimestamp, $afterStartTimestamp);
    }


    /**
     * @return void
     */
    public function testSetReportRenderer()
    {
        // Given
        $route = new InMemoryReportRoute();
        $renderer = new BasicReportRenderer();
        $stopwatch = (new Stopwatch())->setReportRoute($route);

        // When
        $stopwatch = $stopwatch->setReportRenderer($renderer);
        list($beforeStartTimestamp, $afterStartTimestamp) = $this->simpleAct($stopwatch);

        // Then
        $stopwatch->report();
        $output = $route->getRenderedReport();
        $this->assertStartedAtLabel($output);
        $this->assertStartedAtValue($output, $beforeStartTimestamp, $afterStartTimestamp);
    }

}
