<?php

namespace Almasmurad\Stopwatch\Stopwatch\Notices;

use Almasmurad\Stopwatch\Stopwatch\Notices\Common\NoticeInterface;

class NoticesCollection
{
    /**
     * @var NoticeInterface[]
     */
    private $notices = [];

    public function addNotice($notice)
    {
        $this->notices[] = $notice;
    }

    public function hasNotices(): bool
    {
        return !empty($this->notices);
    }

    public function getAllNotices(): array
    {
        return $this->notices;
    }
}