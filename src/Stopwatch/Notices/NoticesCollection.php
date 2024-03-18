<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Notices;

use Almasmurad\Stopwatch\Stopwatch\Notices\Common\NoticeInterface;

class NoticesCollection
{
    /**
     * @var NoticeInterface[]
     */
    private $notices = [];
    /**
     * @return void
     */
    public function addNotice(NoticeInterface $notice)
    {
        $this->notices[] = $notice;
    }

    /**
     * @return NoticeInterface[]
     */
    public function getAllNotices(): array
    {
        return $this->notices;
    }
}
