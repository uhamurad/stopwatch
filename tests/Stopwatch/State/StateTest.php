<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch\State;

use Almasmurad\Stopwatch\State\State;
use PHPUnit\Framework\TestCase;

final class StateTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetStartEventWhenStateJustCreated()
    {
        $state = new State();
        $this->assertFalse($state->getStartEvent()->isHappened());
    }

    /**
     * @return void
     * @dataProvider provideTimestamp
     */
    public function testGetStartEventAfterSetStartTimestamp(float $timestamp)
    {
        $state = new State();
        $state->setStartTimestamp($timestamp);
        $this->assertEquals($timestamp, $state->getStartEvent()->getTimestamp());
    }

    /**
     * @return void
     */
    public function testGetFinishEventWhenStateJustCreated()
    {
        $state = new State();
        $this->assertFalse($state->getFinishEvent()->isHappened());
    }

    /**
     * @return void
     * @dataProvider provideTimestamp
     */
    public function testGetFinishEventAfterSetFinishTimestamp(float $timestamp)
    {
        $state = new State();
        $state->setFinishTimestamp($timestamp);
        $this->assertEquals($timestamp, $state->getFinishEvent()->getTimestamp());
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
