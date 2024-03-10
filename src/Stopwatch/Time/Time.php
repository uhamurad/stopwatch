<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Time;

/**
 * Time class is a simple implementation of TimeInterface for internal purposes.
 *
 * @internal
 */
final class Time implements TimeInterface
{
    const NULL_SECONDS = -1.0;

    /**
     * @var float
     */
    private $seconds;

    private function __construct(float $seconds)
    {
        $this->seconds = $seconds;
    }

    public static function createNonMeasured(): self
    {
        return new self(self::NULL_SECONDS);
    }

    public static function createMeasured(float $seconds): self
    {
        if ($seconds < 0.0) {
            throw new \InvalidArgumentException(sprintf('seconds value must be positive, %f given', $seconds));
        }
        return new self($seconds);
    }

    public function getSeconds(): float
    {
        return max($this->seconds, 0);
    }

    public function isMeasured(): bool
    {
        return self::NULL_SECONDS != $this->seconds;
    }


}
