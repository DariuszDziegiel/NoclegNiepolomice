<?php
namespace ReservationBundle\Utils;

use Doctrine\ORM\EntityManager;
use ReservationBundle\Entity\ReservationBlockedDate;
use ReservationBundle\Utils\DatesPeriod;
use ReservationBundle\Entity\ReservationForm;

class Availability {

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    
    /**
     * Get all blocked dates from given month
     */
    public function getAllReservationBlockedDates(DatesPeriod $datesPeriod)
    {
        return $this
            ->em
            ->getRepository('ReservationBundle:ReservationBlockedDate')
            ->getAllReservationBlockedDates($datesPeriod);
    }


    /**
     * @param $blockedDates
     * @return array
     */
    public function getBlockedDatesForCalendar(DatesPeriod $datesPeriod)
    {
        $blockedDates = $this->getAllReservationBlockedDates($datesPeriod);
        if (!$blockedDates) {
            return [];
        }
        $blockedDays = [];
        /** @var ReservationBlockedDate $blockedDate */
        foreach ($blockedDates as $blockedDate) {
            $blockedDays[$blockedDate->getDate()->format('Y-m-d')] = [
                'class' => 'day-reserved'
            ];
        }
        return $blockedDays;
    }


    /**
     * Get all reservations from given period
     * @param DatesPeriod $datesPeriod
     * @return array
     */
    public function getAllReservationsForm(DatesPeriod $datesPeriod) 
    {
        return $this
            ->em
            ->getRepository('ReservationBundle:ReservationForm')
            ->getAllReservationsInPeriod($datesPeriod);
    }

    /**
     * Get all reservation's dates from given period
     * @param DatesPeriod $datesPeriod
     */
    public function getAllReservationsFormDates(DatesPeriod $datesPeriod): array {
        $reservations = $this->getAllReservationsForm($datesPeriod);
        if (!$reservations) {
            return [];
        }
        $reservationsDates = [];
        /** @var ReservationForm $reservation */
        foreach ($reservations as $reservation) {
            $datesPeriod = new DatesPeriod($reservation->getDateFrom(), $reservation->getDateTo());
            $reservationsDates[] = [
                'dates'          =>  $datesPeriod->getStayDays(),
                'reservation_id' => $reservation->getId()
            ];
        }
        return $reservationsDates;
    }

    /**
     * @return array
     */
    public function getAllReservationFormDatesForCalendar(DatesPeriod $datesPeriod): array
    {
        $reservationFormDates = $this->getAllReservationsFormDates($datesPeriod);
        if (empty($reservationFormDates)) {
            return [];
        }
        $dates = [];
        foreach ($reservationFormDates as $date) {
            foreach ($date['dates'] as $reservationDate) {
                $dates[$reservationDate] = [
                    'class'          => 'day-reserved-first',
                    'reservation_id' =>  $date['reservation_id']
                ];
            }
        }
        return $dates;
    }
    
    
    public function getAllDatesForCalendar() 
    {
        
    }

    /**
     * Check if dates period is available
     * @return bool
     */
    public function isPeriodFree(DatesPeriod $datesPeriod) {
        //check blocked dates
        $blockedDates = $this->getAllReservationBlockedDates($datesPeriod);
        if (!empty($blockedDates)) {
            return false;
        }

        //check reservations
        $reservations = $this->getAllReservationsForm($datesPeriod);
        if ($reservations) {
            return false;
        }

        return true;
    }


    /**
     * @param \DateTime $date
     */
    public function changeDateStatus(\DateTime $date)
    {
        $blockedDateObj = $this->em
            ->getRepository(ReservationBlockedDate::class)
            ->changeDateStatus($date);
    }

    /**
     * Check date status
     * @param \DateTime $date
     * @return bool
     */
    public function getDateStatus(\DateTime $date) {
        
        $dateObj = $this->em
            ->getRepository(ReservationBlockedDate::class)
            ->findOneByDate($date);
        
        if ($dateObj) {
            return [
                'status' => 'blocked',
                'date'   => $date,
                'class'  => 'day-reserved'
            ];
        }
        return [
            'status' => 'free',
            'date'   => $date,
            'class'  => 'day-free' 
        ];
    }


}