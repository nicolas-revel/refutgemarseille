<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductSearch;
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

    public function findAllFiltered (ProductSearch $search): Query
    {
        $query = $this->createQueryBuilder("p");
        if ($search->getQuery()) {
            $query->andWhere("p.name LIKE :query")
                ->setParameter(":query", "%" . $search->getQuery() . "%");
        }
        if ($search->getPreorder()) {
            $query->andWhere("p.releasedAt > :now")
                ->setParameter(":now", new DateTime());
        }
        if ($search->getCategories()->getValues()) {
            $query->innerJoin("p.category", "c")
                ->select("p", "c")
                ->andWhere("c.id IN (:categories)")
                ->setParameter(":categories", $search->getCategories());
        }
        if ($search->getTags()->getValues()) {
            $query->innerJoin("p.tags", "t")
                ->select("p", "t")
                ->andWhere("t.id IN (:tags)")
                ->setParameter(":tags", $search->getTags());
        }
        return $query->getQuery();
    }

}
