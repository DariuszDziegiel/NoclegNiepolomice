<?php

namespace AdminBundle\Repository;
use AdminBundle\Entity\CmsStaticPage;
use Doctrine\ORM\EntityNotFoundException;

/**
 * CmsStaticPageFileRepository
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CmsStaticPageFileRepository extends \Doctrine\ORM\EntityRepository
{
    
    /**
     * Get static page files
     * @param string $type
     * @return array
     */
    public function getFilesByCmsStaticPage(CmsStaticPage $cmsStaticPage, $type = 'img') {
        $qb = $this->createQueryBuilder('file')
            ->where('file.cmsStaticPage = :cmsStaticPage')->setParameter(':cmsStaticPage', $cmsStaticPage)
            ->andWhere('file.type = :type')->setParameter(':type', $type)
            ->orderBy('file.sort', 'ASC')
            ->addOrderBy('file.id', 'DESC')
            ->getQuery();
        return $qb->getResult();
    }








    /**
     * @param $id
     * @param $uploadDir
     */
    public function remove($id, $uploadDir) {
        $em = $this->getEntityManager();
        $cmsStaticPageFileEntity = $em->find('AdminBundle:CmsStaticPageFile', $id);
        if (!$cmsStaticPageFileEntity) {
            throw new EntityNotFoundException();
        }
        //var_dump($uploadDir .'/'. $cmsStaticPageFileEntity->getFileName());
        $filePath = $uploadDir . $cmsStaticPageFileEntity->getFileName();
        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                $em->remove($cmsStaticPageFileEntity);
                $em->flush();
                return true;
            }
            throw new \Exception();
        }
        throw new \Exception();
    }

}
