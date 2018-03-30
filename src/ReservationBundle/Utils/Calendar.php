<?php
namespace ReservationBundle\Utils;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Bundle\TwigBundle\TwigEngine;

class Calendar {
    
    private $em;
    private $twig;
    private $translator;
    
    public function __construct(EntityManager $em, TwigEngine $twig, Translator $translator)
    {
        $this->em   = $em;
        $this->twig = $twig;
        $this->translator = $translator;
    }
    
    /**
     * Draw calendar
     * @param array $calMonths
     * @param array $calDates
     * @return string
     * @throws \Twig_Error
     */
    public function draw(array $calMonth, array $calDates) {
        return $this->twig->render('@App/Utils/Calendar/calendar.html.twig', [
            'calMonth'   => $calMonth,
            'calDates'   => $calDates,
            'calButtons' => $this->calculatePrevAndNextMonth($calMonth['year'], $calMonth['month'])
        ]);
    }

    /**
     * @param int $year
     * @param int $month
     */
    public function calculatePrevAndNextMonth(?int $year, ?int $month): array
    {
        return [
            'prev' => $this->calculatePrevMonth($year, $month),
            'current' => [
                'year'  => $year,
                'month' => $month,
                'title' => $this->translator->trans('calendar.month_'. $month)
            ],
            'next' => $this->calculateNextMonth($year, $month)
        ];
    }

    /**
     * @param int $year
     * @param int $month
     * @return array
     */
    public function calculatePrevMonth(int $year, int $month)
    {
        $month --;
        //january
        if (!$month) {
            $month = 12;
            $year --;
        }
        return [
            'year'  => $year,
            'month' => $month,
            'title' => $this->translator->trans('calendar.month_'. $month)
        ];
    }

    /**
     * @param int $year
     * @param int $month
     */
    public function calculateNextMonth(int $year, int $month)
    {
        $month ++;
        //december
        if ($month == 13) {
            $month = 1;
            $year ++;
        }
        return [
            'year'  => $year,
            'month' => $month,
            'title' => $this->translator->trans('calendar.month_'. $month)
        ];
    }
}