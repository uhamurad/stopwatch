<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Notice;

use Almasmurad\Stopwatch\Notice\Common\NoticeInterface;

final class FinishSkippedNotice implements NoticeInterface
{
    public function getText(): string
    {
        return 'finish() method calling was skipped, because Stopwatch is already finished';
    }
}
