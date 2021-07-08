<?php

namespace App\Repository;

use App\Entity\Product;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct (ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return Query returns an array of latest released products
     */
    public function findReleased (): Query
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.releasedAt < :now')
            ->orderBy('p.releasedAt', 'ASC')
            ->setParameter(':now', new DateTime())
            ->getQuery();
    }

}
