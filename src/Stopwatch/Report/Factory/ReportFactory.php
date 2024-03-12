<?php

declare(strict_types=1);

namespace Almasmurad\Stopwatch\Stopwatch\Report\Factory;

use Almasmurad\Stopwatch\Stopwatch\Report\Report;
use Almasmurad\Stopwatch\Stopwatch\Report\ReportInterface;
use Almasmurad\Stopwatch\Stopwatch\State\Common\StateImmutableInterface;

/**
 * Class ReportFactory is responsible for creating a Report object from a given State.
 *
 * @internal
 */
final class ReportFactory
{
    public function createFromState(StateImmutableInterface $state): ReportInterface
    {
        $this->validateState($state);
        $report = new Report();
        $report->setStartTime($state->getStartTimestamp());
        $report->setFinishTime($state->getFinishTimestamp());
        $report->setAllSeconds($state->getFinishTimestamp() - $state->getStartTimestamp());
        return $report;
    }

    /**
     * @param StateImmutableInterface $state
     * @return void
     */
    private function validateState(StateImmutableInterface $state)
    {
        if (!$state->isComplete()) {
            throw new \DomainException('State is not complete');
        }
    }
}
