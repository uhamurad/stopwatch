<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Notices;

use Almasmurad\Stopwatch\Stopwatch\Notices\Common\NoticeInterface;

class StartSkippedNotice implements NoticeInterface
{
    public function getText(): string
    {
        return 'start() method calling was skipped, because Stopwatch is already started';
    }
}
