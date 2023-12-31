<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    use CountableTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function search($params): array
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p', 'c')
            ->innerJoin('p.category', 'c')
            ->orderBy('p.name', 'DESC')
            ->where('1=1')
            ->setMaxResults(32);;

        if (!empty($params["term"])) {
            $qb->andWhere("LOWER(p.name) like :term")
                ->setParameter(":term", "%".strtolower($params['term'])."%");
        }

        if (!empty($params["brands"])) {
            $qb->andWhere("p.brand in (:brands)")
                ->setParameter(":brands", $params["brands"]);
        }

        if (!empty($params["categories"])) {
            $qb->andWhere("p.category in (:categories)")
                ->setParameter(":categories", $params["categories"]);
        }

        if (!empty($params["page"])) {
            $qb->setFirstResult(($params["page"] - 1) * 32);
        }

        $results = $qb->getQuery()->getResult();
        $total = $this->countAllResults($qb, 'p.id');

        if (!empty($results)) {
            $results[0]->setTotalItems($total);
        }

        return $results;
    }

    public function getBrands()
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p.brand')
            ->groupBy('p.brand')
            ->orderBy('p.brand', 'DESC');
        $results = $qb->getQuery()->getResult();
        return $results;
    }

    public function getValueRange()
    {
        $qb = $this->createQueryBuilder('p')
            ->select('MAX(p.value)', 'MIN(p.value)');
        $results = $qb->getQuery()->getResult();
        return $results;
    }
}
