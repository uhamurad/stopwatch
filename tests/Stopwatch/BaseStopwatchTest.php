<?php declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch;

use Almasmurad\Stopwatch\Stopwatch\BaseStopwatch;
use PHPUnit\Framework\TestCase;

class BaseStopwatchTest extends TestCase
{

    const STARTED_AT = 'Started at';

    public function testReportStarted()
    {

        // arrange
        $stopwatch = new BaseStopwatch();

        // act
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
     * @param string $output
     * @return void
     */
    private function assertStartedAtLabel(string $output)
    {
        $this->assertContains(self::STARTED_AT, $output);
    }

    /**
     * @param string $output
     * @param $beforeStartTimestamp
     * @param $afterStartTimestamp
     * @return void
     */
    private function assertStartedAtValue(string $output, $beforeStartTimestamp, $afterStartTimestamp)
    {
        $startedLine = strstr($output, "\n", true);
        $startedDateStr = substr($startedLine, mb_strlen(self::STARTED_AT));
        $startedDateTimestamp = strtotime($startedDateStr);

        $this->assertGreaterThanOrEqual((int)$beforeStartTimestamp, $startedDateTimestamp);
        $this->assertLessThanOrEqual((int)$afterStartTimestamp, $startedDateTimestamp);
    }
}
