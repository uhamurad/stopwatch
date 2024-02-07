<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch;

use Almasmurad\Stopwatch\Stopwatch;
use PHPUnit\Framework\TestCase;

class OkTest extends TestCase
{
    const STARTED_AT = 'Started at';

    /**
     * @return void
     */
    public function testReportStarted()
    {

        // arrange
        $stopwatch = new Stopwatch();

        // act
        $this->setOutputCallback(function () {});
        $beforeStartTimestamp = microtime(true);
        $stopwatch->start();
        $afterStartTimestamp = microtime(true);

        $stopwatch->stop();

        $stopwatch->report();
        $output = $this->getActualOutput();

        // assert
        $this->assertStartedAtLabel($output);
        $this->assertStartedAtValue($output, $beforeStartTimestamp, $afterStartTimestamp);

    }

    /**
     * @return void
     */
    private function assertStartedAtLabel(string $output)
    {
        $this->assertContains(self::STARTED_AT, $output);
    }

    /**
     * @return void
     */
    private function assertStartedAtValue(string $output, float $beforeStartTimestamp, float $afterStartTimestamp)
    {
        $startedLine = strstr($output, "\n", true) ?: '';
        $startedDateStr = substr($startedLine, mb_strlen(self::STARTED_AT)) ?: '';
        $startedDateTimestamp = strtotime($startedDateStr);

        $this->assertGreaterThanOrEqual((int)$beforeStartTimestamp, $startedDateTimestamp);
        $this->assertLessThanOrEqual((int)$afterStartTimestamp, $startedDateTimestamp);
    }
}
