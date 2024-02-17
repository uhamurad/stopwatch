<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch;

use Almasmurad\Stopwatch\Stopwatch;
use Almasmurad\Stopwatch\Tests\Stopwatch\Common\AbstractTest;

class ReportToFileTest extends AbstractTest
{
    /**
     * @return void
     */
    public function testOkWithDir()
    {
        // arrange
        $stopwatch = new Stopwatch();
        $dir = __DIR__.'/runtime/report';
        $filepath = $dir.'/report.txt';
        @unlink($filepath);
        @rmdir($dir);

        // act
        mkdir($dir, 0777, true);
        list($beforeStartTimestamp, $afterStartTimestamp) = $this->simpleAct($stopwatch);
        $stopwatch->reportToFile($filepath);
        $report = file_get_contents($filepath) ?: '';

        // assert
        $this->assertStartedAtLabel($report);
        $this->assertStartedAtValue($report, $beforeStartTimestamp, $afterStartTimestamp);

        @unlink($filepath);
        @rmdir($dir);

    }

    /**
     * @return void
     */
    public function testEmptyFilename()
    {
        // arrange
        $stopwatch = new Stopwatch();
        $dir = __DIR__.'/runtime/report';
        $filepath = $dir.'/';
        @unlink($filepath);
        @rmdir($dir);

        // act
        mkdir($dir, 0777, true);
        $this->simpleAct($stopwatch);
        $stopwatch->reportToFile($filepath);
        $report = file_get_contents($filepath) ?: '';

        // assert
        $this->assertNoReport($report);

        @unlink($filepath);
        @rmdir($dir);

    }

    /**
     * @return void
     */
    public function testOkWithoutDir()
    {
        // arrange
        $stopwatch = new Stopwatch();
        $dir = __DIR__.'/runtime/report';
        $filepath = $dir.'/report.txt';
        @unlink($filepath);
        @rmdir($dir);

        // act
        list($beforeStartTimestamp, $afterStartTimestamp) = $this->simpleAct($stopwatch);
        $stopwatch->reportToFile($filepath);
        $report = file_get_contents($filepath) ?: '';

        // assert
        $this->assertStartedAtLabel($report);
        $this->assertStartedAtValue($report, $beforeStartTimestamp, $afterStartTimestamp);

        @unlink($filepath);
        @rmdir($dir);

    }

}
