<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch\ReportRoutes;

use Almasmurad\Stopwatch\Stopwatch\ReportRoutes\Common\Exceptions\UnableToProcessReportException;
use Almasmurad\Stopwatch\Stopwatch\ReportRoutes\FileReportRoute;
use Almasmurad\Stopwatch\Tests\Stopwatch\ReportRoutes\Common\AbstractReportRouteTest;

final class FileReportRouteTest extends AbstractReportRouteTest
{
    const REPORT_DIR = __DIR__ . '/../runtime/report';
    const REPORT_BASENAME = '/report.txt';

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->removeReportDir();
    }

    /**
     * @return void
     */
    protected function tearDown()
    {
        $this->removeReportDir();
    }

    /**
     * @param string $report
     * @return void
     * @dataProvider provideReport
     */
    public function testProcessWhenNoFile(string $report)
    {
        // Given
        $filepath = self::REPORT_DIR. self::REPORT_BASENAME;
        $route = new FileReportRoute($filepath);

        // When
        $this->makeReportDir();
        $route->process($report);

        // Then
        $output = file_get_contents($filepath);
        $this->assertEquals($report, $output);
    }

    /**
     * @param string $report
     * @return void
     * @dataProvider provideReport
     */
    public function testProcessWhenNoDir(string $report)
    {
        // Given
        $filepath = self::REPORT_DIR. self::REPORT_BASENAME;
        $route = new FileReportRoute($filepath);

        // When
        $route->process($report);

        // Then
        $output = file_get_contents($filepath);
        $this->assertEquals($report, $output);
    }

    /**
     * @param string $report
     * @return void
     * @dataProvider provideReport
     */
    public function testProcessWhenFileAlreadyHasData(string $report)
    {
        // Given\
        $filepath = self::REPORT_DIR. self::REPORT_BASENAME;
        $route = new FileReportRoute($filepath);

        // When
        $this->makeReportDir();
        $this->makeReportFile("123\n456\n789");
        $route->process($report);

        // Then
        $output = file_get_contents($filepath);
        $this->assertEquals($report, $output);
    }

    /**
     * @param string $report
     * @return void
     * @dataProvider provideReport
     */
    public function testProcessWhenThrownException(string $report)
    {
        // Given
        $wrongFilepath = self::REPORT_DIR.'/';
        $route = new FileReportRoute($wrongFilepath);

        // Then
        $this->expectException(UnableToProcessReportException::class);

        // When
        $route->process($report);
    }

    /**
     * @param string $content
     * @return void
     */
    private function makeReportFile(string $content = '')
    {
        $filepath = self::REPORT_DIR. self::REPORT_BASENAME;
        file_put_contents($filepath, $content);
    }

    /**
     * @return void
     */
    private function makeReportDir()
    {
        mkdir(self::REPORT_DIR, 0777, true);
    }

    /**
     * @return void
     */
    private function removeReportDir()
    {
        $this->removeDirInternal(self::REPORT_DIR);
    }

    /**
     * @return void
     */
    private function removeDirInternal(string $dir)
    {
        $files = array_diff(@scandir($dir) ?: [], ['.', '..']);
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->removeDirInternal("$dir/$file") : @unlink("$dir/$file");
        }
        @rmdir($dir);
    }

}
