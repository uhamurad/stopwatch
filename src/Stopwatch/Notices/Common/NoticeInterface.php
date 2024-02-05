<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Notices\Common;

interface NoticeInterface
{
    /**
     * @return non-empty-string
     */
    public function getText(): string;
}
