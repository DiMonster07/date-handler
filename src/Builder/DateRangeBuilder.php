<?php declare(strict_types=1);

namespace App\Builder;

use App\Exception\InvalidArgumentException;
use App\Model\DateRange;

/**
 * Class DateRangeBuilder.
 */
class DateRangeBuilder
{
    /**
     * @param array $parameters
     *
     * @throws InvalidArgumentException
     *
     * @return DateRange
     */
    public function build(array $parameters) : DateRange
    {
        $this->validateBuildParameters($parameters);

        return new DateRange(
            $parameters['is_allow_edit'],
            $parameters['priority'],
            $parameters['start_date'],
            $parameters['end_date']
        );
    }

    /**
     * @param array $parameters
     *
     * @throws InvalidArgumentException
     */
    private function validateBuildParameters(array $parameters)
    {
        if (!is_bool($parameters['is_allow_edit'])) {
            throw new InvalidArgumentException();
        }

        if (!is_int($parameters['priority']) || $parameters['priority'] < DateRange::MIN_PRIORITY) {
            throw new InvalidArgumentException();
        }

        if (empty($parameters['start_date']) || empty($parameters['end_date'])) {
            throw new InvalidArgumentException();
        }
    }
}