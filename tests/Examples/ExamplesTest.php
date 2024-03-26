<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Examples;

use PHPUnit\Framework\TestCase;

final class ExamplesTest extends TestCase
{

    /**
     * @return void
     */
    public function testBasic()
    {
        $this->expectOutputRegex("/Started at/");
        $this->runExample('basic');
    }

    /**
     * @return void
     */
    public function testCustomReportRenderer()
    {
        $this->expectOutputRegex("/Stopwatch started at/");
        $this->runExample('customReportRenderer');
    }

    /**
     * @doesNotPerformAssertions
     * @return void
     */
    public function testCustomReportSender()
    {
        $this->setOutputCallback(function () {});
        $this->runExample('customReportSender');
    }

    /**
     * @return void
     */
    public function testNotice()
    {
        $this->expectOutputRegex("/Pay attention to the notice/");
        $this->runExample('notice');
    }

    /**
     * @return void
     */
    public function testReport()
    {
        $this->expectOutputRegex("/Started at/");
        $this->runExample('report');
    }

    /**
     * @return void
     */
    public function testWithStartAndStop()
    {
        $this->expectOutputRegex("/Started at/");
        $this->runExample('withStartAndStop');
    }

    /**
     * @param literal-string $name
     * @return void
     */
    private function runExample(string $name)
    {
        include __DIR__ . "/../../examples/{$name}.php";
    }

}
