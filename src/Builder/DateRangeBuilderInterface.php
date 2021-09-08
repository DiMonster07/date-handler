<?php declare(strict_types=1);

namespace App\Builder;

use App\Model\DateRange;

/**
 * Interface DateRangeBuilderInterface.
 */
interface DateRangeBuilderInterface
{
    /**
     * @param array $parameters
     *
     * @return DateRange
     */
    public function build(array $parameters) : DateRange;
}