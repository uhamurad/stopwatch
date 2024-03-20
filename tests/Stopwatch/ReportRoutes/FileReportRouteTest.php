<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch\ReportRoutes;

use Almasmurad\Stopwatch\Stopwatch\ReportRoutes\Common\Exceptions\UnableToProcessReportException;
use Almasmurad\Stopwatch\Stopwatch\ReportRoutes\FileReportRoute;
use Almasmurad\Stopwatch\Tests\Stopwatch\ReportRoutes\Common\AbstractReportRouteTest;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamFile;

final class FileReportRouteTest extends AbstractReportRouteTest
{
    const REPORT_DIR = 'reports';
    const REPORT_BASENAME = 'report.txt';
    const REPORT_FILEPATH = self::REPORT_DIR . '/' . self::REPORT_BASENAME;

    /**
     * @var vfsStreamDirectory
     */
    private $vfsStreamDirectory;

    /**
     * @see https://github.com/bovigo/vfsStream/wiki
     * @return void
     */
    protected function setUp()
    {
        $this->vfsStreamDirectory = vfsStream::setup();
    }

    /**
     * @return void
     * @dataProvider provideReport
     */
    public function testProcessWhenNoFile(string $report)
    {
        // Given
        $filepath = $this->getFilepathUrl();
        $route = new FileReportRoute($filepath);

        // When
        $this->makeReportDir();
        $route->process($report);

        // Then
        $output = $this->getReportFileContent();
        $this->assertEquals($report, $output);
    }

    /**
     * @return void
     * @dataProvider provideReport
     */
    public function testProcessWhenNoDir(string $report)
    {
        // Given
        $filepath = $this->getFilepathUrl();
        $route = new FileReportRoute($filepath);

        // When
        $route->process($report);

        // Then
        $this->assertTrue($this->hasReportFile());
        $output = $this->getReportFileContent();
        $this->assertEquals($report, $output);
    }

    /**
     * @return void
     * @dataProvider provideReport
     */
    public function testProcessWhenFileAlreadyHasData(string $report)
    {
        // Given
        $filepath = $this->getFilepathUrl();
        $route = new FileReportRoute($filepath);

        // When
        $this->makeReportDir();
        $this->makeReportFile("123\n456\n789");
        $route->process($report);

        // Then
        $output = $this->getReportFileContent();
        $this->assertEquals($report, $output);
    }

    /**
     * @return void
     * @dataProvider provideReport
     */
    public function testProcessWhenThrownException(string $report)
    {
        // Given
        $wrongFilepath = $this->vfsStreamDirectory->url() . '/';
        $route = new FileReportRoute($wrongFilepath);

        // Then
        $this->expectException(UnableToProcessReportException::class);

        // When
        $route->process($report);
    }

    private function getFilepathUrl(): string
    {
        return $this->vfsStreamDirectory->url() . '/' . self::REPORT_FILEPATH;
    }

    private function getReportFileContent(): string
    {
        $child = $this->vfsStreamDirectory->getChild(self::REPORT_FILEPATH);
        if (!($child instanceof vfsStreamFile)) {
            throw new \LogicException('It is necessary to check if the file exists');
        }
        return $child->getContent();
    }

    private function hasReportFile(): bool
    {
        return $this->vfsStreamDirectory->hasChild(self::REPORT_FILEPATH);
    }

    /**
     * @return void
     */
    private function makeReportFile(string $content = '')
    {
        $filepath = $this->getFilepathUrl();
        file_put_contents($filepath, $content);
    }

    /**
     * @return void
     */
    private function makeReportDir()
    {
        mkdir($this->vfsStreamDirectory->url() . '/' . self::REPORT_DIR, 0777, true);
    }

}
