<?php
namespace ReservationBundle\Utils;

use AppBundle\Utils\ConfigHelper;
use ReservationBundle\Entity\ReservationForm;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\DependencyInjection\Container;

class MailerReservation 
{
    private $twig;
    private $mailer;
    private $container;
    private $configHelper;

    public function __construct(\Swift_Mailer $mailer, TwigEngine $twig, Container $container, ConfigHelper $configHelper)
    {
        $this->mailer         = $mailer;
        $this->twig           = $twig;
        $this->container      = $container;
        $this->configHelper   = $configHelper;
    }
    
    public function sendNewReservationEmail(ReservationForm $reservationForm)
    {
        $message = new \Swift_Message();
        $message->setContentType('text/html');

        /** Mail Content */
        $message->setSubject('NoclegNiepolomice.pl - NOWA REZERWACJA');
        $message->setBody(
            $this->twig->render('@Reservation/MailReservation/mail_reservation.html.twig', [
                'reservationForm' => $reservationForm
            ])
        );

        $message->setFrom(
            $this->container->getParameter('mailer_from_mail'),
            $this->container->getParameter('mailer_from_name')
        );

        $message->setReplyTo(
            $this->configHelper->getValue('contact_email')
        );
        
        $message->setTo(
            $this->configHelper->getValue('contact_email')
        );

        return $this->mailer
            ->send($message);
    }


}