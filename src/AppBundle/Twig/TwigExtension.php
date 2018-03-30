<?php
namespace AppBundle\Twig;

class TwigExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('day_format', [$this, 'dayFormatFilter'])
        ];
    }

    public function dayFormatFilter(int $dayNumber) {
        if ($dayNumber < 10) {
            $dayNumber = '0'. (int)$dayNumber;
        }
        return $dayNumber;
    }
    
    public function getName()
    {
        return 'twig_extension';
    }
}