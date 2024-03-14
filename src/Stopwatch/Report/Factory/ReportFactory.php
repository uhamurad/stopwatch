<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Report\Factory;

use Almasmurad\Stopwatch\Stopwatch\Notices\NoticesCollection;
use Almasmurad\Stopwatch\Stopwatch\Report\Report;
use Almasmurad\Stopwatch\Stopwatch\Report\ReportInterface;
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
     * @param Report $report
     * @param NoticesCollection $notices
     * @return void
     */
    private function fillFromNotices(Report $report, NoticesCollection $notices)
    {
        foreach ($notices->getAllNotices() as $notice) {
            $report->addNotice($notice->getText());
        }
    }

    /**
     * @param Report $report
     * @param StateInterface $state
     * @return void
     */
    private function fillFromState(Report $report, StateInterface $state)
    {
        $report->setStartTime($state->getStartTimestamp());
        $report->setFinishTime($state->getFinishTimestamp());
        $report->setAllSeconds($state->getFinishTimestamp() - $state->getStartTimestamp());
    }

    /**
     * @param StateInterface $state
     * @return void
     */
    private function validateState(StateInterface $state)
    {
        if (!$state->isComplete()) {
            throw new \DomainException('State is not complete');
        }
    }
}
