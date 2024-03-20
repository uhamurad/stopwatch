<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch\ReportRoutes;

use Almasmurad\Stopwatch\Stopwatch\ReportRoutes\StdoutReportRoute;
use Almasmurad\Stopwatch\Tests\Stopwatch\ReportRoutes\Common\AbstractReportRouteTest;

final class StdoutReportRouteTest extends AbstractReportRouteTest
{
    /**
     * @return void
     * @dataProvider provideReport
     */
    public function testProcess(string $report)
    {
        // Given
        $route = new StdoutReportRoute();

        // When
        $this->setOutputCallback(function () {});
        $route->process($report);

        // Then
        $output = $this->getActualOutput();
        $this->assertEquals($report, $output);
    }

}
