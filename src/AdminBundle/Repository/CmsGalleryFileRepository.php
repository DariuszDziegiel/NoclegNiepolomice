<?php

namespace AdminBundle\Repository;
use AdminBundle\Entity\CmsGallery;

/**
 * CmsGalleryFileRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CmsGalleryFileRepository extends \Doctrine\ORM\EntityRepository
{


    /**
     * Get gallery images
     * @param string $type
     * @return array
     */
    public function getFilesByCmsGallery(CmsGallery $cmsGallery) {
        $qb = $this->createQueryBuilder('file')
            ->where('file.cmsGallery = :cmsGallery')->setParameter(':cmsGallery', $cmsGallery)
            ->andWhere('file.type = :type')->setParameter(':type', 'img')
            ->orderBy('file.sort', 'ASC')
            ->addOrderBy('file.id', 'DESC')
            ->getQuery();
        return $qb->getResult();
    }
    
    
}