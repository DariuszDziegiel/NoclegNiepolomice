<?php

namespace AppBundle\Repository;
use AppBundle\Entity\PaymentStatus;

/**
 * PaymentStatusRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PaymentStatusRepository extends \Doctrine\ORM\EntityRepository
{


    /**
     * Get Payment Status by code
     * @param $code
     * @return null|object
     */
    public function getByCode($code): PaymentStatus {
       $paymentStatus = $this->findOneBy([
           'code' => $code
       ]);
       if (!$paymentStatus) {
           return $this->findOneBy([
               'code' => 'unknown'
           ]);
       }
       return $paymentStatus;
    }


    
    



}
