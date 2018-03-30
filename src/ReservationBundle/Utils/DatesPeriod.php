<?php
namespace ReservationBundle\Utils;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\TwigBundle\TwigEngine;

class DatesPeriod {
    
    private $dateFrom;
    private $dateTo;
    private $stayDates;
    
    public function __construct(\DateTime $dateFrom, \DateTime $dateTo, $isIncludeLastDay = false)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo   = $dateTo;
        $this->correctPeriodDatesOrder();
        $this->setStayDays($this->getStayDays($isIncludeLastDay));
    }


    /**
     * @param \DateTime $date
     */
    public static function createFromMonth(\DateTime $date)
    {
        $year  = $date->format('Y');
        $month = $date->format('m');
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $monthStartDate = new \DateTime($year . '-' . $month . '-01');
        $monthEndDate   = new \DateTime($year . '-' . $month . '-' . $daysInMonth);

        return new DatesPeriod($monthStartDate, $monthEndDate, true);
    }


    /**
     * Correct period dates order
     */
    private function correctPeriodDatesOrder() {
        if ($this->dateFrom > $this->dateTo) {
            $tmpDateFrom = $this->dateFrom;
            $this->dateFrom = $this->dateTo;
            $this->dateTo   = $tmpDateFrom;
        }
    }

    /**
     * Get days from dates period
     * @return array
     */
    public function getStayDays($isIncludeLastDay = false): array {
        $stayDaysObj = new \DatePeriod(
            $this->dateFrom,
            new \DateInterval('P1D'),
            $this->dateTo
        );
        foreach ($stayDaysObj as $date) {
            $stayDays[] = $date->format('Y-m-d');
        }
        if ($isIncludeLastDay) {
            $stayDays[] = $this->dateTo->format('Y-m-d');
        }
        return $stayDays;
    }

    /**
     * @param array $stayDates
     */
    private function setStayDays(array $stayDates) {
        $this->stayDates = $stayDates;
    }

    /**
     * @return \DateTime
     */
    public function getDateFrom(): \DateTime {
        return $this->dateFrom;
    }

    /**
     * @return \DateTime
     */
    public function getDateTo(): \DateTime {
        return $this->dateTo;
    }



}