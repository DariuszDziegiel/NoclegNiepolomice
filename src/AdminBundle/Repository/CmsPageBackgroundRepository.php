<?php

namespace AdminBundle\Repository;

/**
 * CmsPageBackgroundRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CmsPageBackgroundRepository extends \Doctrine\ORM\EntityRepository
{
    
    public function save($object, $persist = true) {
        if ($persist) {
            $this->getEntityManager()->persist($object);
        }
        $this->getEntityManager()->flush();
    }

    /**
     * Get active page backgrounds
     */
    public function getActive() {
        $query = $this->createQueryBuilder('pb')
            ->where('pb.isActive = true')
            ->orderBy('pb.sort', 'ASC')
            ->getQuery();
        return $query->getResult();
    }

}
