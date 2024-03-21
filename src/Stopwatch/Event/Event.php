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
    private $timestamp;

    /**
     * @var self|null
     */
    private static $nonHappenedFlyweight;

    private function __construct(float $timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public static function createNonHappened(): self
    {
        if (self::$nonHappenedFlyweight === null) {
            self::$nonHappenedFlyweight = new self(self::NULL_TIMESTAMP);
        }
        return self::$nonHappenedFlyweight;
    }

    public static function createHappened(float $timestamp): self
    {
        if ($timestamp < 0.0) {
            throw new \InvalidArgumentException(sprintf('time value must be positive, %f given', $timestamp));
        }
        return new self($timestamp);
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
        return max($this->timestamp, 0);
    }

    public function isHappened(): bool
    {
        return self::NULL_TIMESTAMP != $this->timestamp;
    }
}
