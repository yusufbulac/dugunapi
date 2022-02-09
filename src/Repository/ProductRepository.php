<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findProducts(array $filter = []){
        $qb = $this-> createQueryBuilder("p");

        $qb->select("partial p.{id,name,price,status,createdAt}");

        if(!empty($filter["name"])){
            $qb->andWhere("p.name = :name")
                ->setParameter("name",$filter["name"]);
        }

        if(!empty($filter["status"])){
            $qb->andWhere("p.status = :status")
                ->setParameter("status",$filter["status"]);
        }

        if (!empty($filter['startPrice'])) {
            $qb->andWhere($qb->expr()->gte('p.price', $filter['startPrice']));
        }

        if (!empty($filter['endPrice'])) {
            $qb->andWhere($qb->expr()->lte('p.price', $filter['endPrice']));
        }


        if (!empty($filter['startDate'])) {
            $qb->andWhere($qb->expr()->gte('p.createdAt',':startDate'))
            ->setParameter('startDate',$filter['startDate']);
        }

        if (!empty($filter['endDate'])) {
            $qb->andWhere($qb->expr()->lte('p.createdAt', ':endDate'))
                ->setParameter('endDate',$filter['endDate']);
        }

        return $qb->getQuery()->getArrayResult();
    }
}
