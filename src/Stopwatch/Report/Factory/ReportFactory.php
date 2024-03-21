<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Report\Factory;

use Almasmurad\Stopwatch\Stopwatch\Notices\Collection\NoticesCollection;
use Almasmurad\Stopwatch\Stopwatch\Report\Common\ReportInterface;
use Almasmurad\Stopwatch\Stopwatch\Report\Report;
use Almasmurad\Stopwatch\Stopwatch\State\Common\StateInterface;

/**
 * Class ReportFactory is responsible for creating a Report object from a given State.
 *
 * @internal
 */
final class ReportFactory
{
    public function create(StateInterface $state, NoticesCollection $notices): ReportInterface
    {
        $this->validateState($state);

        $report = new Report();
        $this->fillFromState($report, $state);
        $this->fillFromNotices($report, $notices);

        return $report;
    }

    /**
     * @return void
     */
    private function fillFromNotices(Report $report, NoticesCollection $notices)
    {
        foreach ($notices->getAllNotices() as $notice) {
            $report->addNotice($notice->getText());
        }
    }

    /**
     * @return void
     */
    private function fillFromState(Report $report, StateInterface $state)
    {
        $report->setStartTime($state->getStartEvent()->getTimestamp());
        $report->setFinishTime($state->getFinishEvent()->getTimestamp());
        $report->setAllSeconds($state->getFinishEvent()->getTimestamp() - $state->getStartEvent()->getTimestamp());
    }

    /**
     * @return void
     */
    private function validateState(StateInterface $state)
    {
        if (!$state->isComplete()) {
            throw new \DomainException('State is not complete');
        }
    }
}
