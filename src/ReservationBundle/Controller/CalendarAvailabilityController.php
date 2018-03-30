<?php

namespace ReservationBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use ReservationBundle\Utils\DatesPeriod;

/**
 * Class CalendarAvailabilityController
 * @package ReservationBundle\Controller
 */
class CalendarAvailabilityController extends Controller
{
    /**
     * @Route("/calendar/draw/{year}/{month}/{numberOfMonths}",
     *     name="calendar_draw",
     *     options={"expose" = "true"}
     * )
     * @Route("/admin/calendar/draw/{year}/{month}/{numberOfMonths}",
     *     name="calendar_draw_admin",
     *     options={"expose" = "true"}
     * )
     */
    public function drawCalendarAction($year, $month, $numberOfMonths = 1)
    {
        //calendar
        $calendar = $this->get('app.calendar');
        
        //selected month
        $datesPeriod = DatesPeriod::createFromMonth(new \DateTime($year. '-' . $month));

        $availability  = $this->get('app.availability');

        //reservation dates
        $reservationsDates = $availability->getAllReservationFormDatesForCalendar($datesPeriod);

        //blocked dates
        $blockedDates = $availability->getBlockedDatesForCalendar($datesPeriod);

        //@TODO: calendar for multiple months
        $calMonth = [
            'year'  => $year,
            'month' => $month
        ];
        
        return new Response(
            $calendar->draw(
                $calMonth,
                array_merge($reservationsDates, $blockedDates)
            )
        );
    }




}
