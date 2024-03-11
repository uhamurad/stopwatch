<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Tests\Stopwatch\Common;

trait SecondsProvidersTrait
{
    /**
     * @return float[][]
     */
    public function provideValidSeconds(): array
    {
        return [
            'empty seconds' => [0.0],
            'integer seconds' => [1234567890.0],
            'simple seconds' => [1234567890.123],
        ];
    }

    /**
     * @return float[][]
     */
    public function provideInvalidSeconds(): array
    {
        return [
            'small seconds' => [-0.000000001],
            'one seconds' => [-1.0],
            'integer seconds' => [-1234567890.0],
            'simple seconds' => [-1234567890.123],
        ];
    }
}
