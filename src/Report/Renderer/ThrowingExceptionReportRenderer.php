<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Report\Renderer;

use Almasmurad\Stopwatch\Report\Common\ReportInterface;
use Almasmurad\Stopwatch\Report\Renderer\Common\Exceptions\UnableToRenderReportException;
use Almasmurad\Stopwatch\Report\Renderer\Common\ReportRendererInterface;

/**
 * Class ThrowingExceptionReportRenderer always throws UnableToRenderReportException. Used for testing purposes
 */
final class ThrowingExceptionReportRenderer implements ReportRendererInterface
{
    /**
     * @var string
     */
    private $exceptionMessage;

    public function __construct(string $exceptionMessage = 'Test message')
    {
        $this->exceptionMessage = $exceptionMessage;
    }

    public function render(ReportInterface $report): string
    {
        throw new UnableToRenderReportException($this->exceptionMessage);
    }
}
