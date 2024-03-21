<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Notices;

use Almasmurad\Stopwatch\Notices\Common\NoticeInterface;

final class FinishSkippedNotice implements NoticeInterface
{
    public function getText(): string
    {
        return 'finish() method calling was skipped, because Stopwatch is already finished';
    }
}
