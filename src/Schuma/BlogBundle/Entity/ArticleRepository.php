<?php

namespace Schuma\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository{

    public function getLast($number = 5){
        $qb = $this->createQueryBuilder('a');
        $qb->setMaxResults($number)
            ->orderBy('a.date', 'DESC');
        return $qb->getQuery()
            ->getResult();
    }
}
