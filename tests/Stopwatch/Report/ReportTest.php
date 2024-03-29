<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch\Report;

use Almasmurad\Stopwatch\Report\Report;
use Almasmurad\Stopwatch\Tests\Stopwatch\Common\SecondsProvidersTrait;
use Almasmurad\Stopwatch\Tests\Stopwatch\Common\TimestampsProvidersTrait;
use PHPUnit\Framework\TestCase;

final class ReportTest extends TestCase
{
    use SecondsProvidersTrait;
    use TimestampsProvidersTrait;

    /**
     * @return void
     */
    public function testGetStartEventWhenJustCreated()
    {
        $report = new Report();
        $this->assertFalse($report->getStartEvent()->isHappened());
    }

    /**
     * @return void
     * @dataProvider provideValidTimestamp
     */
    public function testSetStartEventWhenSetValidTime(float $time)
    {
        $report = new Report();
        $report->setStartTime($time);
        $this->assertTrue($report->getStartEvent()->isHappened());
        $this->assertEquals($time, $report->getStartEvent()->getTimestamp());
    }

    /**
     * @return void
     * @dataProvider provideInvalidTimestamp
     */
    public function testSetStartEventWhenSetInvalidTime(float $time)
    {
        $report = new Report();
        $this->expectException(\InvalidArgumentException::class);
        $report->setStartTime($time);
    }

    /**
     * @return void
     */
    public function testGetFinishEventWhenJustCreated()
    {
        $report = new Report();
        $this->assertFalse($report->getFinishEvent()->isHappened());
    }

    /**
     * @return void
     * @dataProvider provideValidTimestamp
     */
    public function testSetFinishEventWhenSetValidTime(float $time)
    {
        $report = new Report();
        $report->setFinishTime($time);
        $this->assertTrue($report->getFinishEvent()->isHappened());
        $this->assertEquals($time, $report->getFinishEvent()->getTimestamp());
    }

    /**
     * @return void
     * @dataProvider provideInvalidTimestamp
     */
    public function testSetFinishEventWhenSetInvalidTime(float $time)
    {
        $report = new Report();
        $this->expectException(\InvalidArgumentException::class);
        $report->setFinishTime($time);
    }

    /**
     * @return void
     */
    public function testGetAllTimeWhenJustCreated()
    {
        $report = new Report();
        $this->assertFalse($report->getAllTime()->isMeasured());
    }

    /**
     * @return void
     * @dataProvider provideValidSeconds
     */
    public function testSetAllTimeWhenSetValidInterval(float $seconds)
    {
        $report = new Report();
        $report->setAllSeconds($seconds);
        $this->assertTrue($report->getAllTime()->isMeasured());
        $this->assertEquals($seconds, $report->getAllTime()->getSeconds());
    }

    /**
     * @return void
     * @dataProvider provideInvalidSeconds
     */
    public function testSetAllTimeWhenSetInvalidInterval(float $seconds)
    {
        $report = new Report();
        $this->expectException(\InvalidArgumentException::class);
        $report->setAllSeconds($seconds);
    }

    /**
     * @return void
     */
    public function testHasNoticesWhenJustCreated()
    {
        $report = new Report();
        $this->assertFalse($report->hasNotices());
    }

    /**
     * @return void
     */
    public function testGetNoticesWhenJustCreated()
    {
        $report = new Report();
        $this->assertEmpty($report->getNotices());
    }

    /**
     * @return void
     */
    public function testGetNoticesWhenAddOneNotice()
    {
        $report = new Report();
        $notice = 'non-empty-string';
        $report->addNotice($notice);
        $this->assertCount(1, $report->getNotices());
        $this->assertEquals($notice, $report->getNotices()[0]);
    }

    /**
     * @return void
     */
    public function testGetNoticesWhenAddSomeNotices()
    {
        $report = new Report();
        $notice1 = 'non empty string';
        $notice2 = 'another non empty string';
        $report->addNotice($notice1);
        $report->addNotice($notice2);
        $this->assertCount(2, $report->getNotices());
        $this->assertEquals($notice1, $report->getNotices()[0]);
        $this->assertEquals($notice2, $report->getNotices()[1]);
    }

}
