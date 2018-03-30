<?php

namespace ReservationBundle\Controller;

use ReservationBundle\Utils\DatesPeriod;
use ReservationBundle\Entity\ReservationForm;
use ReservationBundle\Form\ReservationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/cms_reservation")
 */
class ReservationFormController extends Controller
{
    /**
     * @Route("/add", name="cms_reservation_add", options={"expose" = "true"})
     * @param Request $request
     */
    public function addReservationAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $cmsReservation = new ReservationForm();

        $form = $this->createForm(ReservationFormType::class, $cmsReservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $dateFrom = $form->get('dateFrom')->getData();
            $dateTo   = $form->get('dateTo')->getData();

            $datesPeriod = new DatesPeriod(
                new \DateTime($dateFrom),
                new \DateTime($dateTo)
            );

            if ($this->get('app.availability')->isPeriodFree($datesPeriod)) {

                $cmsReservation->setDateFrom(new \DateTime($dateFrom));
                $cmsReservation->setDateTo(new \DateTime($dateTo));

                $em->persist($cmsReservation);
                $em->flush();

                //send reservation info email
                $mailerReservation = $this->get('app.mailer_reservation');
                $mailerReservation->sendNewReservationEmail($cmsReservation);

                return new JsonResponse([
                    'message' => 'Wybrany termin został zarezerwowany. <br />Skontaktujemy się z Tobą w celu potwierdzenia pobytu.',
                ], 200);

            } else {

                return new JsonResponse([
                    'message' => 'Wybrany termin jest niedostępny. Wybierz inną datę przyjazdu i wyjazdu.',
                    'form'    => $this->renderView('@App/Default/partails/reservation_form.html.twig', [
                        'reservationForm' => $form->createView()
                    ])
                ], 400);

            }
        }

        $response = new JsonResponse([
            'message' => 'Uzupełnij dane zgodnie z wyświetlonymi komunikatami',
            'form'    => $this->renderView('@App/Default/partails/reservation_form.html.twig', [
                'reservationForm' => $form->createView()
            ])
        ], 400);

        return $response;
    }

}
