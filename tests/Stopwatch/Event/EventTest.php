<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch\Event;

use Almasmurad\Stopwatch\Stopwatch\Event\Event;
use Exception;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    /**
     * @return void
     * @dataProvider provideInvalidTimestamp
     */
    public function testCreateHappenedWithWrongTime(float $timestamp)
    {
        $this->expectException(\InvalidArgumentException::class);
        $event = Event::createHappened($timestamp);
    }

    /**
     * @return void
     * @dataProvider provideValidTimestamp
     */
    public function testIsHappenedWhenCreateNonHappened()
    {
        $event = Event::createNonHappened();
        $this->assertFalse($event->isHappened());
    }

    /**
     * @return void
     * @dataProvider provideValidTimestamp
     */
    public function testIsHappenedWhenCreateHappened(float $timestamp)
    {
        $event = Event::createHappened($timestamp);
        $this->assertTrue($event->isHappened());
    }

    /**
     * @return void
     * @dataProvider provideValidTimestamp
     */
    public function testGetTimestampWhenCreateHappened(float $timestamp)
    {
        $event = Event::createHappened($timestamp);
        $this->assertEquals($timestamp, $event->getTimestamp());
    }

    /**
     * @return void
     */
    public function testGetTimestampWhenCreateNonHappened()
    {
        $event = Event::createNonHappened();
        $this->assertEquals(0.0, $event->getTimestamp());
    }

    /**
     * @return void
     * @dataProvider provideValidTimestamp
     * @throws Exception
     */
    public function testGetDateTimeWhenCreateHappened(float $timestamp)
    {
        $event = Event::createHappened($timestamp);
        // note that DateTime::getTimestamp does not support milliseconds
        $this->assertEquals($timestamp, (float)$event->getDateTime()->format('U.u'));
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetDateTimeWhenCreateNonHappened()
    {
        $event = Event::createNonHappened();
        // note that DateTime::getTimestamp does not support milliseconds
        $this->assertEquals(0, (float)$event->getDateTime()->format('U.u'));
    }

    /**
     * @return float[][]
     */
    public function provideValidTimestamp(): array
    {
        return [
            'empty timestamp' => [0.0],
            'integer timestamp' => [1234567890.0],
            'simple timestamp' => [1234567890.123],
        ];
    }

    /**
     * @return float[][]
     */
    public function provideInvalidTimestamp(): array
    {
        return [
            'small timestamp' => [-0.000000001],
            'one timestamp' => [-1.0],
            'integer timestamp' => [-1234567890.0],
            'simple timestamp' => [-1234567890.123],
        ];
    }
}
