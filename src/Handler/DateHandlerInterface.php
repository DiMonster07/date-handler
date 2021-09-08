<?php declare(strict_types=1);

namespace App\Handler;

use App\Builder\DateRangeBuilder;

interface DateHandlerInterface
{
    /**
     * @param DateRangeBuilder $dateRangeBuilder
     * @param ...$dateRanges
     */
    public function __construct(DateRangeBuilder $dateRangeBuilder, ...$dateRanges);

    public function handle();
}