<?php

namespace App\Repository;

use App\Entity\CartHasProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CartHasProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartHasProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartHasProduct[]    findAll()
 * @method CartHasProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartHasProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartHasProduct::class);
    }

    // /**
    //  * @return CartHasProduct[] Returns an array of CartHasProduct objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CartHasProduct
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
