<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch\State;

use Almasmurad\Stopwatch\Stopwatch\State\State;
use PHPUnit\Framework\TestCase;

class StateTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetStartTimestampWhenStateJustCreated()
    {
        $state = new State();
        $this->assertEquals(0, $state->getStartTimestamp());
    }

    /**
     * @return void
     * @dataProvider provideTimestamp
     */
    public function testGetStartTimestampAfterSetStartTimestamp(float $timestamp)
    {
        $state = new State();
        $state->setStartTimestamp($timestamp);
        $this->assertEquals($timestamp, $state->getStartTimestamp());
    }

    /**
     * @return void
     */
    public function testGetFinishTimestampWhenStateJustCreated()
    {
        $state = new State();
        $this->assertEquals(0, $state->getFinishTimestamp());
    }

    /**
     * @return void
     * @dataProvider provideTimestamp
     */
    public function testGetFinishTimestampAfterSetFinishTimestamp(float $timestamp)
    {
        $state = new State();
        $state->setFinishTimestamp($timestamp);
        $this->assertEquals($timestamp, $state->getFinishTimestamp());
    }


    /**
     * @return void
     */
    public function testIsStartTimestampSetWhenStateJustCreated()
    {
        $state = new State();
        $this->assertFalse($state->isStartTimestampSet());
    }

    /**
     * @return void
     * @dataProvider provideTimestamp
     */
    public function testIsStartTimestampSetAfterSetStartTimestamp(float $timestamp)
    {
        $state = new State();
        $state->setStartTimestamp($timestamp);
        $this->assertEquals($timestamp !== 0.0, $state->isStartTimestampSet());
    }

    /**
     * @return void
     */
    public function testIsFinishTimestampSetWhenStateJustCreated()
    {
        $state = new State();
        $this->assertFalse($state->isFinishTimestampSet());
    }

    /**
     * @return void
     * @dataProvider provideTimestamp
     */
    public function testIsFinishTimestampSetAfterSetFinishTimestamp(float $timestamp)
    {
        $state = new State();
        $state->setFinishTimestamp($timestamp);
        $this->assertEquals($timestamp !== 0.0, $state->isFinishTimestampSet());
    }

    /**
     * @return float[][]
     */
    public function provideTimestamp(): array
    {
        return [
            'empty timestamp' => [0.0],
            'simple timestamp' => [1234567890.123],
        ];
    }
}
