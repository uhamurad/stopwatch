<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Notices;

use Almasmurad\Stopwatch\Stopwatch\Notices\Common\NoticeInterface;

class StopSkippedNotice implements NoticeInterface
{
    public function getText(): string
    {
        return 'stop() method calling was skipped, because Stopwatch is already stopped';
    }
}
