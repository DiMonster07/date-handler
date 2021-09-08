<?php declare(strict_types=1);

namespace App\Handler;

use App\Exception\InvalidArgumentException;
use App\Builder\DateRangeBuilder;
use App\Model\DateRange;

class DateHandler implements DateHandlerInterface
{
    /**
     * @var DateRangeBuilder
     */
    protected DateRangeBuilder $dateRangeBuilder;

    /**
     * @var array|DateRange[]
     */
    protected array $dateRanges = [];

    /**
     * @var array|\DateTime[]
     */
    protected array $datesAllowedForEdit = [];

    /**
     * {@inheritdoc}
     */
    public function __construct(DateRangeBuilder $dateRangeBuilder, ...$dateRanges)
    {
        $this->dateRangeBuilder = $dateRangeBuilder;

        $this
            ->configureDateRanges($dateRanges)
            ->determineDatesAllowedForEdit()
        ;
    }

    public function handle()
    {
        // TODO do something
    }

    /**
     * @return array|\DateTime[]
     */
    public function getDatesAllowedForEdit() : array
    {
        return $this->datesAllowedForEdit;
    }

    /**
     * @param array $dateRanges
     *
     * @throws InvalidArgumentException
     *
     * @return $this
     */
    protected function configureDateRanges(array $dateRanges) : self
    {
        if (count($dateRanges) === 0) {
            throw new InvalidArgumentException('DateHandler object required date ranges');
        }

        foreach ($dateRanges as $dateRange) {
            $this->dateRanges[] = $this->dateRangeBuilder->build($dateRange);
        }

        return $this;
    }

    protected function determineDatesAllowedForEdit() : self
    {
        $interval = new \DateInterval('P1D');

        $dateList = [];
        foreach ($this->dateRanges as $dateRange) {
            $datePeriod = new \DatePeriod($dateRange->getStartDate(), $interval, $dateRange->getEndDate());
            foreach ($datePeriod as $day) {
                $dayAsString = $day->format('d.m.Y');

                if (!array_key_exists($dayAsString, $dateList)) {
                    $dateList[$dayAsString] = [
                        'original_date' => $day, /* Keep original date for optional using in future */
                        'max_priority'  => $dateRange->getPriority(),
                        'is_allow_edit' => $dateRange->isAllowEdit(),
                    ];

                    continue;
                }

                if ($dateRange->getPriority() > $dateList[$dayAsString]['max_priority']) {
                    $dateList[$dayAsString] = [
                        'original_date' => $day,
                        'max_priority'  => $dateRange->getPriority(),
                        'is_allow_edit' => $dateRange->isAllowEdit(),
                    ];
                }
            }
        }

        ksort($dateList);

        foreach ($dateList as $date) {
            if (!$date['is_allow_edit']) {
                continue;
            }

            $this->datesAllowedForEdit[] = $date['original_date'];
        }

        return $this;
    }
}