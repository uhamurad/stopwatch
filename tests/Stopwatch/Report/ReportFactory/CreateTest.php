<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch\Report\ReportFactory;

use Almasmurad\Stopwatch\Stopwatch\Notices\NoticesCollection;
use Almasmurad\Stopwatch\Stopwatch\Notices\StartSkippedNotice;
use Almasmurad\Stopwatch\Stopwatch\Report\Factory\ReportFactory;
use Almasmurad\Stopwatch\Stopwatch\State\State;
use Almasmurad\Stopwatch\Tests\Stopwatch\Common\TimestampsProvidersTrait;
use PHPUnit\Framework\TestCase;

final class CreateTest extends TestCase
{
    use TimestampsProvidersTrait;

    /**
     * @return void
     */
    public function testWhenJustCreatedState()
    {
        $factory = new ReportFactory();
        $state = new State();
        $notices = new NoticesCollection();

        $this->expectException(\DomainException::class);
        $report = $factory->create($state, $notices);
    }

    /**
     * @return void
     * @dataProvider provideValidTimestamp
     */
    public function testWhenStateIncomplete(float $time)
    {
        $factory = new ReportFactory();
        $state = new State();
        $notices = new NoticesCollection();
        $state->setStartTimestamp($time);

        $this->expectException(\DomainException::class);
        $report = $factory->create($state, $notices);
    }

    /**
     * @return void
     * @dataProvider provideValidTimestamp
     */
    public function testGetEventsWhenValidTimestampsSet(float $time)
    {
        $factory = new ReportFactory();
        $state = new State();
        $notices = new NoticesCollection();

        $state->setStartTimestamp($time);
        $state->setFinishTimestamp($time);

        $report = $factory->create($state, $notices);

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
        $notices = new NoticesCollection();

        $state->setStartTimestamp($startTime);
        $state->setFinishTimestamp($finishTime);

        $report = $factory->create($state, $notices);
        $this->assertTrue($report->getAllTime()->isMeasured());
        $this->assertEquals($seconds, $report->getAllTime()->getSeconds(), '', 0.001);
    }

    /**
     * @return void
     */
    public function testGetNoticesWhenEmpty()
    {
        $factory = new ReportFactory();
        $state = new State();
        $notices = new NoticesCollection();

        $state->setStartTimestamp(1234567890.124);
        $state->setFinishTimestamp(1234567890.124);

        $report = $factory->create($state, $notices);
        $this->assertFalse($report->hasNotices());
        $this->assertEmpty($report->getNotices());
    }

    /**
     * @return void
     */
    public function testGetNoticesWhenFilled()
    {
        $factory = new ReportFactory();
        $state = new State();
        $notices = new NoticesCollection();

        $state->setStartTimestamp(1234567890.124);
        $state->setFinishTimestamp(1234567890.124);
        $notices->addNotice(new StartSkippedNotice());

        $report = $factory->create($state, $notices);
        $this->assertTrue($report->hasNotices());
        $this->assertArrayHasKey(0, $report->getNotices());
        $this->assertEquals('start() method calling was skipped, because Stopwatch is already started', $report->getNotices()[0]);
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
