<?php declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch\BaseStopwatch;

use Almasmurad\Stopwatch\Stopwatch\BaseStopwatch;
use PHPUnit\Framework\TestCase;

class WrongMethodsCallingOrderTest extends TestCase
{

    const ERRORS_LABEL = 'Errors';
    const NOTICES_LABEL = 'Notices';
    const START_MISSED_NOTICE_MSG = 'start() method calling was missed. Time of Stopwatch creation is taken as start time';
    const START_SKIPPED_NOTICE_MSG = 'start() method calling was skipped, because Stopwatch is already started';
    const STOP_MISSED_NOTICE_MSG = 'stop() method calling was missed. Time of calling report() method is taken as stop time';
    const STOP_SKIPPED_NOTICE_MSG = 'stop() method calling was skipped, because Stopwatch is already stopped';

    public function testReport()
    {
        // arrange
        $stopwatch = new BaseStopwatch();

        // act
        $output = $this->act($stopwatch, ['report']);

        // assert
        $this->assertContains(self::NOTICES_LABEL, $output);
        $this->assertContains(self::START_MISSED_NOTICE_MSG, $output);
        $this->assertContains(self::STOP_MISSED_NOTICE_MSG, $output);
    }

    public function testStopReport()
    {
        // arrange
        $stopwatch = new BaseStopwatch();

        // act
        $output = $this->act($stopwatch, ['stop', 'report']);

        // assert
        $this->assertContains(self::NOTICES_LABEL, $output);
        $this->assertContains(self::START_MISSED_NOTICE_MSG, $output);
    }

    public function testStartReport()
    {
        // arrange
        $stopwatch = new BaseStopwatch();

        // act
        $output = $this->act($stopwatch, ['start', 'report']);

        // assert
        $this->assertContains(self::NOTICES_LABEL, $output);
        $this->assertContains(self::STOP_MISSED_NOTICE_MSG, $output);
    }

    public function testStopStartReport()
    {
        // arrange
        $stopwatch = new BaseStopwatch();

        // act
        $output = $this->act($stopwatch, ['stop', 'start', 'report']);

        // assert
        $this->assertContains(self::NOTICES_LABEL, $output);
        $this->assertContains(self::START_MISSED_NOTICE_MSG, $output);
        $this->assertContains(self::START_SKIPPED_NOTICE_MSG, $output);
    }

    /**
     * @param BaseStopwatch $stopwatch
     * @param array $methods
     * @return string
     */
    private function act(BaseStopwatch $stopwatch, array $methods): string
    {
        $this->setOutputCallback(function() {});
        foreach ($methods as $method){
            switch ($method){
                case 'start':
                    $stopwatch->start();
                    break;
                case 'stop':
                    $stopwatch->stop();
                    break;
                case 'report':
                    $stopwatch->report();
                    break;
                default:
                    throw new \InvalidArgumentException(sprintf('Method "%s" of BaseStopwatch is unknown', $method));
            }
        }
        return $this->getActualOutput();
    }

}
