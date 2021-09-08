<?php declare(strict_types=1);

namespace App\Model;

use App\Exception\InvalidArgumentException;

/**
 * Class DateRange.
 */
class DateRange
{
    public const MIN_PRIORITY = 0;

    /**
     * @var bool
     */
    protected bool $isAllowEdit;

    /**
     * @var int
     */
    protected int $priority;

    /**
     * @var \DateTime
     */
    protected \DateTime $startDate;

    /**
     * @var \DateTime
     */
    protected \DateTime $endDate;

    /**
     * @param bool   $isAllowEdit
     * @param int    $priority
     * @param string $startDate
     * @param string $endDate
     */
    public function __construct(bool $isAllowEdit, int $priority, string $startDate, string $endDate)
    {
        $this->isAllowEdit = $isAllowEdit;
        $this->priority    = $priority;

        try {
            $this->startDate = new \DateTime($startDate);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Arg $startDate of DateRange must be compatible with DateTime date format');
        }

        try {
            $this->endDate = new \DateTime($endDate);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Arg $endDate of DateRange must be compatible with DateTime date format');
        }

        $this->endDate = $this->endDate->add(new \DateInterval('PT1S')); /* For DatePeriod correct iteration */
    }

    /**
     * @return bool
     */
    public function isAllowEdit() : bool
    {
        return $this->isAllowEdit;
    }

    /**
     * @return int
     */
    public function getPriority() : int
    {
        return $this->priority;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate() : \DateTime
    {
        return $this->startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate() : \DateTime
    {
        return $this->endDate;
    }
}