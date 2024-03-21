<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Notice\Common;

interface NoticeInterface
{
    /**
     * @return non-empty-string
     */
    public function getText(): string;
}
