<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Notices;

use Almasmurad\Stopwatch\Stopwatch\Notices\Common\NoticeInterface;

class StartMissedNotice implements NoticeInterface
{
    public function getText(): string
    {
        return 'start() method calling was missed. Time of Stopwatch creation is taken as start time';
    }
}
