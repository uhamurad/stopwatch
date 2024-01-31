<?php

namespace Almasmurad\Stopwatch\Stopwatch\Notices;

use Almasmurad\Stopwatch\Stopwatch\Notices\Common\NoticeInterface;

class StopMissedNotice implements NoticeInterface
{
    public function getText(): string
    {
        return 'stop() method calling was missed. Time of calling report() method is taken as stop time';
    }
}