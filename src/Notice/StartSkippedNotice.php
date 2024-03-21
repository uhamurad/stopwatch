<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Notice;

use Almasmurad\Stopwatch\Notice\Common\NoticeInterface;

final class StartSkippedNotice implements NoticeInterface
{
    public function getText(): string
    {
        return 'start() method calling was skipped, because Stopwatch is already started';
    }
}
