<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Event;

use Exception;

/**
 * Event class is a simple implementation of EventInterface for internal purposes.
 *
 * @internal
 */
final class Event implements EventInterface
{
    const NULL_TIMESTAMP = -1.0;

    /**
     * @var float
     */
    private $time;

    private function __construct(float $time)
    {
        $this->time = $time;
    }

    public static function createNonHappened(): self
    {
        return new self(self::NULL_TIMESTAMP);
    }

    public static function createHappened(float $time): self
    {
        if ($time < 0.0) {
            throw new \InvalidArgumentException(sprintf('time value must be positive, %f given', $time));
        }
        return new self($time);
    }

    /**
     * @throws Exception
     */
    public function getDateTime(): \DateTimeInterface
    {
        $parts = explode(".", (string) $this->getTimestamp());
        $integerPart = (int) $parts[0];
        $fractionalPart = $parts[1] ?? "0";
        return new \DateTimeImmutable(date("Y-m-d H:i:s.", $integerPart) . $fractionalPart);
    }

    public function getTimestamp(): float
    {
        return max($this->time, 0);
    }

    public function isHappened(): bool
    {
        return self::NULL_TIMESTAMP != $this->time;
    }
}
