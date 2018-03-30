<?php
namespace ReservationBundle\Utils;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\TwigBundle\TwigEngine;

class Reservation {

    private $em;
    private $reservationDates;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Get all reservations in given month
     * @param $year
     * @param $month
     * @return array
     */
    public function getAllReservationsInMonth($year, $month)
    {
        $repo = $this->em->getRepository('ReservationBundle:ReservationForm');
        return $repo->getAllReservationsInMonth($year, $month);
    }

}