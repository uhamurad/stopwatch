<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch\ReportRoutes\Common;

use PHPUnit\Framework\TestCase;

abstract class AbstractReportRouteTest extends TestCase
{
    /**
     * @return string[][]
     */
    public function provideReport(): array
    {
        return [
            'empty report' => [""],
            'simple report' => [
                "Started at Sat, 02 Mar 2024 16:00:11 +0000\n" .
                "———————————————————————————————————————————\n" .
                "All time | 0.000s"
            ],
        ];
    }

}
