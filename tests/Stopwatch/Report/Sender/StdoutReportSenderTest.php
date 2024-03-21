<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch\Report\Sender;

use Almasmurad\Stopwatch\Report\Sender\StdoutReportSender;
use Almasmurad\Stopwatch\Tests\Stopwatch\Report\Sender\Common\AbstractReportSenderTest;

final class StdoutReportSenderTest extends AbstractReportSenderTest
{
    /**
     * @return void
     * @dataProvider provideReport
     */
    public function testSend(string $report)
    {
        // Given
        $sender = new StdoutReportSender();

        // When
        $this->setOutputCallback(function () {});
        $sender->send($report);

        // Then
        $output = $this->getActualOutput();
        $this->assertEquals($report, $output);
    }

}
