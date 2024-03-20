<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch\Report\Renderer;

use Almasmurad\Stopwatch\Stopwatch\Report\Renderer\BasicReportRenderer;
use Almasmurad\Stopwatch\Stopwatch\Report\Report;
use Almasmurad\Stopwatch\Tests\Stopwatch\Common\SecondsProvidersTrait;
use Almasmurad\Stopwatch\Tests\Stopwatch\Common\TimestampsProvidersTrait;
use PHPUnit\Framework\TestCase;

final class BasicReportRendererTest extends TestCase
{
    use SecondsProvidersTrait;
    use TimestampsProvidersTrait;

    /**
     * @return void
     */
    public function testWhenJustCreatedReport()
    {
        $renderer = new BasicReportRenderer();
        $report = new Report();

        $text = $renderer->render($report);

        list($headerValue, $bodyValue, $notices) = $this->assertAndParseStructureOfReportText($text);

        $this->assertEquals('[unknown]', $headerValue);
        $this->assertEquals('[unknown]', $bodyValue);
        $this->assertEmpty($notices);
    }

    /**
     * @return void
     * @dataProvider provideValidTimestamp
     */
    public function testWhenSetStartTime(float $timestamp)
    {
        $renderer = new BasicReportRenderer();
        $report = new Report();
        $report->setStartTime($timestamp);

        $text = $renderer->render($report);
        list($headerValue, $bodyValue, $notices) = $this->assertAndParseStructureOfReportText($text);
        $expectedHeaderValue = date('r', (int)$timestamp);
        $this->assertEquals($expectedHeaderValue, $headerValue);
        $this->assertEquals('[unknown]', $bodyValue);
    }

    /**
     * @return void
     * @dataProvider provideValidTimestamp
     */
    public function testWhenSetFinishTime(float $timestamp)
    {
        $renderer = new BasicReportRenderer();
        $report = new Report();
        $report->setFinishTime($timestamp);

        $text = $renderer->render($report);
        list($headerValue, $bodyValue, $notices) = $this->assertAndParseStructureOfReportText($text);
        $this->assertEquals('[unknown]', $headerValue);
        $this->assertEquals('[unknown]', $bodyValue);
    }

    /**
     * @return void
     * @dataProvider provideValidSeconds
     */
    public function testWhenSetAllSeconds(float $seconds)
    {
        $renderer = new BasicReportRenderer();
        $report = new Report();
        $report->setAllSeconds($seconds);

        $text = $renderer->render($report);
        list($headerValue, $bodyValue, $notices) = $this->assertAndParseStructureOfReportText($text);
        $this->assertEquals('[unknown]', $headerValue);
        $expectedBodyValue = number_format($seconds, 3, '.', ' ') . "s";
        $this->assertEquals($expectedBodyValue, $bodyValue);
    }

    /**
     * @return void
     */
    public function testWhenAddOneNotice()
    {
        $renderer = new BasicReportRenderer();
        $report = new Report();
        $report->addNotice('Lorem ipsum dolor sit amet');

        $text = $renderer->render($report);
        list($headerValue, $bodyValue, $notices) = $this->assertAndParseStructureOfReportText($text);
        $this->assertEquals(['Lorem ipsum dolor sit amet'], $notices);
    }

    /**
     * @return void
     */
    public function testWhenAddSomeNotices()
    {
        $renderer = new BasicReportRenderer();
        $report = new Report();
        $report->addNotice('Lorem ipsum dolor sit amet');
        $report->addNotice('consectetur adipiscing elit');

        $text = $renderer->render($report);
        list($headerValue, $bodyValue, $notices) = $this->assertAndParseStructureOfReportText($text);
        $this->assertEquals(['Lorem ipsum dolor sit amet', 'consectetur adipiscing elit'], $notices);
    }

    /**
     * @param string $text
     * @return array{string, string, string[]}
     */
    private function assertAndParseStructureOfReportText(string $text): array
    {
        $breakLineLength = 42;
        $breakLine = "\n" . str_repeat('—', $breakLineLength) . "\n";

        $parts = explode($breakLine, $text);
        $this->assertGreaterThanOrEqual(2, count($parts), 'Report has wrong format');
        $this->assertLessThanOrEqual(3, count($parts), 'Report has wrong format');

        $headerPart = $parts[0] ?? '';
        $headerValue = $this->assertAndParseHeaderPart($headerPart);

        $bodyPart = $parts[1] ?? '';
        $bodyValue = $this->assertAndParseBodyPart($bodyPart);

        $noticesPart = $parts[2] ?? '';
        $notices = $this->assertAndParseNoticesPart($noticesPart);

        return [$headerValue, $bodyValue, $notices];
    }

    private function assertAndParseHeaderPart(string $headerPart): string
    {
        $lines = explode("\n", $headerPart);
        $this->assertCount(1, $lines, 'Report header part has wrong format');
        $header = $lines[0] ?? '';
        $this->assertStringStartsWith('Started at ', $header);
        return substr($header, strlen('Started at '));
    }

    private function assertAndParseBodyPart(string $bodyPart): string
    {
        $lines = explode("\n", $bodyPart);
        $this->assertCount(1, $lines, 'Report body part has wrong format');
        $body = $lines[0] ?? '';
        $this->assertStringStartsWith('All time | ', $body);
        return substr($body, strlen('All time | '));
    }

    /**
     * @param string $noticesPart
     * @return string[]
     */
    private function assertAndParseNoticesPart(string $noticesPart): array
    {
        if (!$noticesPart) {
            return [];
        }

        $lines = explode("\n", $noticesPart);
        $this->assertGreaterThanOrEqual(2, count($lines), 'Report notices part has wrong format');
        $noticesHeader = array_shift($lines) ?: '';
        $this->assertEquals('Notices:', $noticesHeader);

        $notices = [];
        foreach ($lines as $line) {
            $this->assertStringStartsWith(' - ', $line);
            $notices[] = substr($line, strlen(' - '));
        }
        return $notices;
    }


}
