<?php

namespace ReservationBundle\Repository;
use ReservationBundle\Utils\DatesPeriod;
use Doctrine\ORM\Internal\Hydration\ArrayHydrator;

/**
 * ReservationFormRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReservationFormRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * @param DatesPeriod $datesPeriod
     */
    public function getAllReservationsInPeriod(DatesPeriod $datesPeriod)
    {
        $qb = $this->createQueryBuilder('rf')
            ->select('rf')
            ->where('rf.dateFrom >= :period_start AND rf.dateFrom <= :period_end')
            ->orWhere('rf.dateTo > :period_start AND rf.dateTo <= :period_end')
            ->orWhere('rf.dateFrom <= :period_start AND rf.dateTo >= :period_end')
            ->setParameters([
                ':period_start' => $datesPeriod->getDateFrom(),
                ':period_end'   => $datesPeriod->getDateTo()
            ]);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $year
     * @param $month
     */
    public function getAllReservationsInMonth(int $year, int $month)
    {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $qb = $this->createQueryBuilder('rf')
            ->where('rf.dateFrom >= :monthFirstDay AND rf.dateFrom <= :monthLastDay')
            ->setParameters([
                'monthFirstDay' => new \DateTime($year . '-' . $month . '-01'),
                'monthLastDay'  => new \DateTime($year . '-' . $month . '-' . $daysInMonth)
            ]);

        return $qb->getQuery()->getResult();
    }


}