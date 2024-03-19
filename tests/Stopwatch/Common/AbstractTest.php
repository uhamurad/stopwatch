<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch\Common;

use Almasmurad\Stopwatch\Stopwatch\StopwatchInterface;
use PHPUnit\Framework\TestCase;

abstract class AbstractTest extends TestCase
{
    const STARTED_AT = 'Started at';

    /**
     * @return void
     */
    protected function assertStartedAtLabel(string $output)
    {
        $this->assertContains(self::STARTED_AT, $output);
    }

    /**
     * @return void
     */
    protected function assertNoReport(string $output)
    {
        $this->assertNotContains(self::STARTED_AT, $output);
    }

    /**
     * @return void
     */
    protected function assertStartedAtValue(string $output, float $beforeStartTimestamp, float $afterStartTimestamp)
    {
        $startedLine = strstr($output, "\n", true) ?: '';
        $startedDateStr = substr($startedLine, mb_strlen(self::STARTED_AT)) ?: '';
        $startedDateTimestamp = strtotime($startedDateStr);

        $this->assertGreaterThanOrEqual((int)$beforeStartTimestamp, $startedDateTimestamp);
        $this->assertLessThanOrEqual((int)$afterStartTimestamp, $startedDateTimestamp);
    }

    /**
     * @return float[]
     * @throws \Exception
     */
    protected function simpleAct(StopwatchInterface $stopwatch): array
    {
        $beforeStartTimestamp = microtime(true);
        $stopwatch->start();
        usleep(random_int(100, 100000));
        $afterStartTimestamp = microtime(true);
        $stopwatch->finish();
        $afterFinishTimestamp = microtime(true);
        return [$beforeStartTimestamp, $afterStartTimestamp, $afterFinishTimestamp];
    }
}
