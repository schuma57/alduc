<?php

namespace Schuma\FaqBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * QuestionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QuestionRepository extends EntityRepository
{
    public function getTwoLast(){
        $qb = $this->createQueryBuilder('q');
        $qb->setMaxResults(2)
            ->orderBy('q.date', 'DESC');

        return $qb->getQuery()
            ->getResult();
    }
}
