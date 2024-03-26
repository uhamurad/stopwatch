<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch\Stopwatch;

use Almasmurad\Stopwatch\Report\Renderer\BasicReportRenderer;
use Almasmurad\Stopwatch\Report\Sender\InMemoryReportSender;
use Almasmurad\Stopwatch\Stopwatch;
use Almasmurad\Stopwatch\Tests\Stopwatch\Common\AbstractTest;

final class ConstructorAndSettersTest extends AbstractTest
{
    /**
     * @return void
     */
    public function testSetReportSender()
    {
        // Given
        $testReportSender = new InMemoryReportSender();
        $stopwatch = new Stopwatch();

        // When
        $stopwatch = $stopwatch->setReportSender($testReportSender);
        list($beforeStartTimestamp, $afterStartTimestamp) = $this->simpleAct($stopwatch);
        $stopwatch->report();

        // Then
        $output = $testReportSender->getRenderedReport();
        $this->assertStartedAtLabel($output);
        $this->assertStartedAtValue($output, $beforeStartTimestamp, $afterStartTimestamp);
    }


    /**
     * @return void
     */
    public function testSetReportRenderer()
    {
        // Given
        $reportSender = new InMemoryReportSender();
        $renderer = new BasicReportRenderer();
        $stopwatch = (new Stopwatch())->setReportSender($reportSender);

        // When
        $stopwatch = $stopwatch->setReportRenderer($renderer);
        list($beforeStartTimestamp, $afterStartTimestamp) = $this->simpleAct($stopwatch);

        // Then
        $stopwatch->report();
        $output = $reportSender->getRenderedReport();
        $this->assertStartedAtLabel($output);
        $this->assertStartedAtValue($output, $beforeStartTimestamp, $afterStartTimestamp);
    }


    /**
     * @return void
     */
    public function testConstructorWithReportSender()
    {
        // Given
        $testReportSender = new InMemoryReportSender();
        $stopwatch = new Stopwatch($testReportSender);

        // When
        list($beforeStartTimestamp, $afterStartTimestamp) = $this->simpleAct($stopwatch);
        $stopwatch->report();

        // Then
        $output = $testReportSender->getRenderedReport();
        $this->assertStartedAtLabel($output);
        $this->assertStartedAtValue($output, $beforeStartTimestamp, $afterStartTimestamp);
    }


    /**
     * @return void
     */
    public function testConstructorWithReportRenderer()
    {
        // Given
        $sender = new InMemoryReportSender();
        $renderer = new BasicReportRenderer();
        $stopwatch = new Stopwatch($sender, $renderer);

        // When
        list($beforeStartTimestamp, $afterStartTimestamp) = $this->simpleAct($stopwatch);

        // Then
        $stopwatch->report();
        $output = $sender->getRenderedReport();
        $this->assertStartedAtLabel($output);
        $this->assertStartedAtValue($output, $beforeStartTimestamp, $afterStartTimestamp);
    }

}
