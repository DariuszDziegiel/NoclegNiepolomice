<?php

namespace AdminBundle\Repository;
use AdminBundle\Entity\CmsArticleCategory;
use Doctrine\ORM\Query\Expr;


/**
 * CmsArticleCategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CmsArticleCategoryRepository extends \Doctrine\ORM\EntityRepository
{
    
    /**
     * @return \Doctrine\Common\Collections\Collection|static
     */
    public function getEvents(CmsArticleCategory $cmsArticleCategory) {
        $query = $this->createQueryBuilder('cat')
            ->join('AdminBundle:CmsArticle', 'art', Expr\Join::WITH)
            //->orderBy('date', 'DESC')
            ->getQuery();
        return $query->getResult();
    }
    
    
}
