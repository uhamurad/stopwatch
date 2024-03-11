<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch\Common;

trait TimestampsProvidersTrait
{
    /**
     * @return float[][]
     */
    public function provideValidTimestamp(): array
    {
        return [
            'empty timestamp' => [0.0],
            'integer timestamp' => [1234567890.0],
            'simple timestamp' => [1234567890.123],
        ];
    }

    /**
     * @return float[][]
     */
    public function provideInvalidTimestamp(): array
    {
        return [
            'small timestamp' => [-0.000000001],
            'one timestamp' => [-1.0],
            'integer timestamp' => [-1234567890.0],
            'simple timestamp' => [-1234567890.123],
        ];
    }
}
