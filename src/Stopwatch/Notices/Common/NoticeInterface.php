<?php

namespace Almasmurad\Stopwatch\Stopwatch\Notices\Common;

interface NoticeInterface
{
    /**
     * @return non-empty-string
     */
    public function getText(): string;
}