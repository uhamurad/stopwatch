<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch;

use Almasmurad\Stopwatch\Stopwatch\Stopwatch;
use PHPUnit\Framework\TestCase;

final class NoticesTest extends TestCase
{
    const ERRORS_LABEL = 'Errors';
    const NOTICES_LABEL = 'Notices';
    const MSG_START_SKIPPED = 'start() method calling was skipped, because Stopwatch is already started';
    const MSG_FINISH_SKIPPED = 'finish() method calling was skipped, because Stopwatch is already finished';
    const START = 'start';
    const FINISH = 'finish';
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
                [self::FINISH],
                [],
            ],
            [
                [self::REPORT],
                [],
            ],

            // 2 methods
            [
                [self::START, self::FINISH],
                [],
            ],
            [
                [self::START, self::REPORT],
                [],
            ],
            [
                [self::FINISH, self::START],
                [],
            ],
            [
                [self::FINISH, self::REPORT],
                [],
            ],
            [
                [self::REPORT, self::START],
                [],
            ],
            [
                [self::REPORT, self::FINISH],
                [],
            ],

            // 3 methods
            [
                [self::START, self::FINISH, self::REPORT],
                [],
            ],
            [
                [self::START, self::REPORT, self::FINISH],
                [],
            ],

            [
                [self::FINISH, self::START, self::REPORT],
                [self::MSG_START_SKIPPED],
            ],
            [
                [self::FINISH, self::REPORT, self::START],
                [],
            ],

            [
                [self::REPORT, self::START, self::FINISH],
                [],
            ],
            [
                [self::REPORT, self::FINISH, self::START],
                [],
            ],

            // with repeats
            [
                [self::START, self::START, self::FINISH, self::REPORT],
                [self::MSG_START_SKIPPED],
            ],
            [
                [self::START, self::FINISH, self::FINISH, self::REPORT],
                [self::MSG_FINISH_SKIPPED],
            ],
            [
                [self::START, self::START, self::FINISH, self::FINISH, self::REPORT],
                [self::MSG_START_SKIPPED, self::MSG_FINISH_SKIPPED],
            ],

        ];
    }
    /**
     * @param string[] $methods
     */
    private function act(Stopwatch $stopwatch, array $methods): string
    {
        $this->setOutputCallback(function () {});
        foreach ($methods as $method) {
            switch ($method) {
                case self::START:
                    $stopwatch->start();
                    break;
                case self::FINISH:
                    $stopwatch->finish();
                    break;
                case self::REPORT:
                    $stopwatch->report();
                    break;
                default:
                    throw new \InvalidArgumentException(sprintf('Method "%s" of Stopwatch is unknown', $method));
            }
        }
        return $this->getActualOutput();
    }

    /**
     * @param string[] $expectedNoticesMessages
     * @return void
     */
    private function assert(array $expectedNoticesMessages, string $output)
    {
        if ($expectedNoticesMessages !== []) {
            $this->assertContains(self::NOTICES_LABEL, $output);
            foreach ($expectedNoticesMessages as $message) {
                $this->assertContains($message, $output);
            }
        } else {
            $this->assertNotContains(self::NOTICES_LABEL, $output);
        }
    }

}
