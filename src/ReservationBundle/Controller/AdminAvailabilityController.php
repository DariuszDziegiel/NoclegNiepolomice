<?php
namespace ReservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/availability")
 * Class AdminAvailabilityController
 */
class AdminAvailabilityController extends Controller
{
    
    /**
     * @Route("/calendar", name="admin_availability_calendar")
     * @Breadcrumb("Dostępność", routeName="admin_availability_calendar")
     */
    public function indexAction()
    {
        return $this->render('@Reservation/AdminAvailability/admin_availability_index.html.twig', [
        ]);
    }

    /**
     * @Route("/change_date_status/{date}",
     *     name = "admin_availability_change_date_status",
     *     options = {"expose" = "true"}
     *  )
     */
    public function changeDateStatusAction($date, Request $request)
    {
        $date = new \DateTime($date);

        $availabilityService = $this->get('app.availability');
        $availabilityService->changeDateStatus($date);

        $dateStatus = $availabilityService->getDateStatus($date);

        return new JsonResponse($dateStatus, 200);
    }





}
