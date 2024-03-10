<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch\Time;

use Almasmurad\Stopwatch\Stopwatch\Time\Time;
use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{
    /**
     * @return void
     * @dataProvider provideInvalidSeconds
     */
    public function testCreateMeasuredWithWrongSeconds(float $seconds)
    {
        $this->expectException(\InvalidArgumentException::class);
        $time = Time::createMeasured($seconds);
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
     * @return float[][]
     */
    public function provideValidSeconds(): array
    {
        return [
            // 'empty seconds' => [0.0],
            'integer seconds' => [1234567890.0],
            'simple seconds' => [1234567890.123],
        ];
    }

    /**
     * @return float[][]
     */
    public function provideInvalidSeconds(): array
    {
        return [
            'small seconds' => [-0.000000001],
            'one seconds' => [-1.0],
            'integer seconds' => [-1234567890.0],
            'simple seconds' => [-1234567890.123],
        ];
    }
}
