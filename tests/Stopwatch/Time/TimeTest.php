<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch\Time;

use Almasmurad\Stopwatch\Stopwatch\Time\Time;
use Almasmurad\Stopwatch\Tests\Stopwatch\Common\SecondsProvidersTrait;
use PHPUnit\Framework\TestCase;

final class TimeTest extends TestCase
{
    use SecondsProvidersTrait;

    /**
     * @return void
     * @dataProvider provideInvalidSeconds
     */
    public function testCreateMeasuredWithWrongSeconds(float $seconds)
    {
        $this->expectException(\InvalidArgumentException::class);
        Time::createMeasured($seconds);
    }

    /**
     * @return void
     * @dataProvider provideValidSeconds
     */
    public function testIsMeasuredWhenCreateNonMeasured()
    {
        $time = Time::createNonMeasured();
        $this->assertFalse($time->isMeasured());
    }

    /**
     * @return void
     * @dataProvider provideValidSeconds
     */
    public function testIsMeasuredWhenCreateMeasured(float $seconds)
    {
        $time = Time::createMeasured($seconds);
        $this->assertTrue($time->isMeasured());
    }

    /**
     * @return void
     * @dataProvider provideValidSeconds
     */
    public function testGetSecondsWhenCreateMeasured(float $seconds)
    {
        $time = Time::createMeasured($seconds);
        $this->assertEquals($seconds, $time->getSeconds());
    }

    /**
     * @return void
     */
    public function testGetSecondsWhenCreateNonMeasured()
    {
        $time = Time::createNonMeasured();
        $this->assertEquals(0.0, $time->getSeconds());
    }


    /**
     * @return void
     */
    public function testCreateNonMeasuredReturnsFlyweight()
    {
        $time = Time::createNonMeasured();
        $time2 = Time::createNonMeasured();
        $this->assertSame($time, $time2);
    }


}
