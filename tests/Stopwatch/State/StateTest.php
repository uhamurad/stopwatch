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
        $this->assertEquals(State::NULL_TIMESTAMP, $state->getStartTimestamp());
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
        $this->assertEquals(State::NULL_TIMESTAMP, $state->getFinishTimestamp());
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
        $this->assertEquals($timestamp !== State::NULL_TIMESTAMP, $state->isStartTimestampSet());
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
        $this->assertEquals($timestamp !== State::NULL_TIMESTAMP, $state->isFinishTimestampSet());
    }

    /**
     * @return void
     */
    public function testIsCompleteWhenJustCreated()
    {
        $state = new State();
        $this->assertFalse($state->isComplete());
    }

    /**
     * @return void
     */
    public function testIsCompleteWhenStartSet()
    {
        $state = new State();
        $state->setStartTimestamp(1234567890.123);
        $this->assertFalse($state->isComplete());
    }

    /**
     * @return void
     */
    public function testIsCompleteWhenFinishSet()
    {
        $state = new State();
        $state->setFinishTimestamp(1234567890.123);
        $this->assertFalse($state->isComplete());
    }
    /**
     * @return void
     */
    public function testIsCompleteWhenStartAndFinishSet()
    {
        $state = new State();
        $state->setStartTimestamp(234567890.123);
        $state->setFinishTimestamp(1234567890.123);
        $this->assertTrue($state->isComplete());
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
