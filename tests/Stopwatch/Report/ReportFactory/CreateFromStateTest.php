<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch\Report\ReportFactory;

use Almasmurad\Stopwatch\Stopwatch\Report\Factory\ReportFactory;
use Almasmurad\Stopwatch\Stopwatch\State\State;
use Almasmurad\Stopwatch\Tests\Stopwatch\Common\TimestampsProvidersTrait;
use PHPUnit\Framework\TestCase;

class CreateFromStateTest extends TestCase
{
    use TimestampsProvidersTrait;

    /**
     * @return void
     */
    public function testWhenJustCreatedState()
    {
        $factory = new ReportFactory();
        $state = new State();

        $this->expectException(\DomainException::class);
        $report = $factory->createFromState($state);
    }

    /**
     * @return void
     * @dataProvider provideValidTimestamp
     */
    public function testWhenStateIncomplete(float $time)
    {
        $factory = new ReportFactory();
        $state = new State();
        $state->setStartTimestamp($time);

        $this->expectException(\DomainException::class);
        $report = $factory->createFromState($state);
    }

    /**
     * @return void
     * @dataProvider provideValidTimestamp
     */
    public function testGetEventsWhenValidTimestampsSet(float $time)
    {
        $factory = new ReportFactory();
        $state = new State();
        $state->setStartTimestamp($time);
        $state->setFinishTimestamp($time);

        $report = $factory->createFromState($state);

        $this->assertEquals($time, $report->getStartEvent()->getTimestamp());
        $this->assertEquals($time, $report->getFinishEvent()->getTimestamp());
    }

    /**
     * @return void
     * @dataProvider provideAllTimeGivenAndResult
     */
    public function testGetAllTime(float $startTime, float $finishTime, float $seconds)
    {
        $factory = new ReportFactory();
        $state = new State();
        $state->setStartTimestamp($startTime);
        $state->setFinishTimestamp($finishTime);

        $report = $factory->createFromState($state);
        $this->assertTrue($report->getAllTime()->isMeasured());
        $this->assertEquals($seconds, $report->getAllTime()->getSeconds(), '', 0.001);
    }

    /**
     * @return float[][]
     */
    public function provideAllTimeGivenAndResult(): array
    {
        return [
            'instant' => [1234567890.124, 1234567890.124, 0.0],
            'simple' => [1234567890.0, 1234567890.124, 0.124],
        ];
    }
}
