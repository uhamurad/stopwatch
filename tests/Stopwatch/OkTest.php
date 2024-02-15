<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch;

use Almasmurad\Stopwatch\Stopwatch;
use Almasmurad\Stopwatch\Tests\Stopwatch\Common\AbstractTest;

class OkTest extends AbstractTest
{
    /**
     * @return void
     */
    public function testReportStarted()
    {

        // arrange
        $stopwatch = new Stopwatch();

        // act
        $this->setOutputCallback(function () {});
        $beforeStartTimestamp = microtime(true);
        $stopwatch->start();
        $afterStartTimestamp = microtime(true);

        $stopwatch->stop();

        $stopwatch->report();
        $output = $this->getActualOutput();

        // assert
        $this->assertStartedAtLabel($output);
        $this->assertStartedAtValue($output, $beforeStartTimestamp, $afterStartTimestamp);

    }

}
