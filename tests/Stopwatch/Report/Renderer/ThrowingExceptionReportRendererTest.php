<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch\Report\Renderer;

use Almasmurad\Stopwatch\Stopwatch\Report\Renderer\Exceptions\UnableToRenderReportException;
use Almasmurad\Stopwatch\Stopwatch\Report\Renderer\ThrowingExceptionReportRenderer;
use Almasmurad\Stopwatch\Stopwatch\Report\Report;
use PHPUnit\Framework\TestCase;

final class ThrowingExceptionReportRendererTest extends TestCase
{
    /**
     * @return void
     */
    public function testRender()
    {
        $renderer = new ThrowingExceptionReportRenderer();
        $report = new Report();

        $this->expectException(UnableToRenderReportException::class);
        $renderer->render($report);
    }

}
