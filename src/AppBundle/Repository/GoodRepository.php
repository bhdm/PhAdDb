<?php

namespace AppBundle\Repository;

/**
 * GoodRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GoodRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByMonth($mediaplanId, $priceId){
        $qb = $this->createQueryBuilder('g');
        $qb->select('g');
        $qb
            ->leftJoin('g.price', 'price')
            ->leftJoin('g.mediaplan', 'mediaplan')
            ->where('mediaplan.id = :mediaplanId')
            ->andWhere('price.id = :priceId')
            ->setParameter(':mediaplanId', $mediaplanId )
            ->setParameter(':priceId', $priceId )
            ->orderBy('g.month', 'ASC')
            ->orderBy('g.title', 'ASC');
        $result = $qb->getQuery()->getResult();

        $resultArray = array();
        foreach ($result as $g){
            $resultArray[$g->getMonth()][] = $g;
        }

        return $resultArray;
    }

    public function findGoods($mediaplanId){
        $qb = $this->createQueryBuilder('g');
        $qb->select('g');
        $qb
            ->leftJoin('g.price', 'price')
            ->leftJoin('g.mediaplan', 'mediaplan')
            ->where('mediaplan.id = :mediaplanId')
            ->setParameter(':mediaplanId', $mediaplanId )
            ->groupBy('price.id')
            ->distinct('price.id')
            ->orderBy('g.title', 'ASC');
        $result = $qb->getQuery()->getResult();
        return $result;
    }
}
