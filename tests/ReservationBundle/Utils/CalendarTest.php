<?php
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CalendarTest extends KernelTestCase
{
    
    protected $calendar;
    
    protected function setUp()
    {
        self::bootKernel();
        $this->calendar = static::$kernel->getContainer()
            ->get('app.calendar');
    }

    public function testServiceReachable()
    {
        
    }

    public function testCalculatePrevMonth()
    {

    }

    protected function tearDown()
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
    }

}