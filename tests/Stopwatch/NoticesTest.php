<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch;

use Almasmurad\Stopwatch\Stopwatch;
use PHPUnit\Framework\TestCase;

class NoticesTest extends TestCase
{
    const ERRORS_LABEL = 'Errors';
    const NOTICES_LABEL = 'Notices';
    const MSG_START_SKIPPED = 'start() method calling was skipped, because Stopwatch is already started';
    const MSG_STOP_SKIPPED = 'stop() method calling was skipped, because Stopwatch is already stopped';
    const START = 'start';
    const STOP = 'stop';
    const REPORT = 'report';


    /**
     * @param string[] $calledMethods
     * @param string[] $expectedNoticesMessages
     * @return void
     * @dataProvider provideData
     */
    public function testByMethods(array $calledMethods, array $expectedNoticesMessages)
    {
        // arrange
        $stopwatch = new Stopwatch();

        // act
        $output = $this->act($stopwatch, $calledMethods);

        // assert
        $this->assert($expectedNoticesMessages, $output);
    }

    /**
     * @return string[][][]
     */
    public function provideData(): array
    {
        return [

            // 1 method
            [
                [self::START],
                [],
            ],
            [
                [self::STOP],
                [],
            ],
            [
                [self::REPORT],
                [],
            ],

            // 2 methods
            [
                [self::START, self::STOP],
                [],
            ],
            [
                [self::START, self::REPORT],
                [],
            ],
            [
                [self::STOP, self::START],
                [],
            ],
            [
                [self::STOP, self::REPORT],
                [],
            ],
            [
                [self::REPORT, self::START],
                [],
            ],
            [
                [self::REPORT, self::STOP],
                [],
            ],

            // 3 methods
            [
                [self::START, self::STOP, self::REPORT],
                [],
            ],
            [
                [self::START, self::REPORT, self::STOP],
                [],
            ],

            [
                [self::STOP, self::START, self::REPORT],
                [self::MSG_START_SKIPPED],
            ],
            [
                [self::STOP, self::REPORT, self::START],
                [],
            ],

            [
                [self::REPORT, self::START, self::STOP],
                [],
            ],
            [
                [self::REPORT, self::STOP, self::START],
                [],
            ],

            // with repeats
            [
                [self::START, self::START, self::STOP, self::REPORT],
                [self::MSG_START_SKIPPED],
            ],
            [
                [self::START, self::STOP, self::STOP, self::REPORT],
                [self::MSG_STOP_SKIPPED],
            ],
            [
                [self::START, self::START, self::STOP, self::STOP, self::REPORT],
                [self::MSG_START_SKIPPED, self::MSG_STOP_SKIPPED],
            ],

        ];
    }

    /**
     * @param Stopwatch $stopwatch
     * @param string[] $methods
     * @return string
     */
    private function act(Stopwatch $stopwatch, array $methods): string
    {
        $this->setOutputCallback(function () {
        });
        foreach ($methods as $method) {
            switch ($method) {
                case self::START:
                    $stopwatch->start();
                    break;
                case self::STOP:
                    $stopwatch->stop();
                    break;
                case self::REPORT:
                    $stopwatch->report();
                    break;
                default:
                    throw new \InvalidArgumentException(sprintf('Method "%s" of BaseStopwatch is unknown', $method));
            }
        }
        return $this->getActualOutput();
    }

    /**
     * @param string[] $expectedNoticesMessages
     * @param string $output
     * @return void
     */
    private function assert(array $expectedNoticesMessages, string $output)
    {
        if (count($expectedNoticesMessages)) {
            $this->assertContains(self::NOTICES_LABEL, $output);
            foreach ($expectedNoticesMessages as $message) {
                $this->assertContains($message, $output);
            }
        } else {
            $this->assertNotContains(self::NOTICES_LABEL, $output);
        }
    }

}
