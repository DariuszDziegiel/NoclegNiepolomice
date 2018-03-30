<?php

namespace ReservationBundle\Controller;

use ReservationBundle\Entity\ReservationForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/reservations")
 * @Security("has_role('ROLE_ADMIN')")
 */
class AdminReservationsController extends Controller
{

    /**
     * @Route("/{year}/{month}",
     *     name="admin_reservations_index",
     *     requirements = {
     *         "year" = "\d+",
     *         "month" = "\d+"
     *     }
     * )
     * @Breadcrumb("Rezerwacje", routeName="admin_reservations_index")
     */

    public function indexAction($year = null, $month = null, Request $request)
    {
        if (!$year || !$month) {
            $year  = date('Y');
            $month = date('n');
        }

        $calendar         = $this->get('app.calendar');
        $calMonthsDisplay = $calendar->calculatePrevAndNextMonth($year, $month);


        $reservations = $this->get('app.reservation')
            ->getAllReservationsInMonth($year, $month);
        
        return $this->render('@Reservation/AdminReservations/admin_reservations_index.html.twig', [
            'year'             => $year,
            'month'            => $month,
            'calMonthsDisplay' => $calMonthsDisplay,
            'reservations'     => $reservations
        ]);
    }


    /**
     * @Route("/{id}/remove", name="admin_reservations_remove", requirements={"id" = "\d+"})
     * @ParamConverter("reservationForm", class="ReservationBundle:ReservationForm", converter="")
     */
    public function removeAction(ReservationForm $reservationForm, Request $request) {

        //remove eentity
        $em = $this->getDoctrine()->getManager();
        $em->remove($reservationForm);
        $em->flush();

        $this->addFlash('remove_message', 'Rezerwacja została usunięta');
        
        return $this->redirectToRoute('admin_reservations_index', [
            'year'  => $request->get('year'),
            'month' => $request->get('month')
        ]);
    }
    
    
    

}