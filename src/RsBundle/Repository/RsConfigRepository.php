<?php

namespace RsBundle\Repository;

/**
 * RsConfigRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RsConfigRepository extends \Doctrine\ORM\EntityRepository
{

    public function save($object, $persist = true) {
        if ($persist) {
            $this->getEntityManager()->persist($object);
        }
        $this->getEntityManager()->flush();
    }
    
}
