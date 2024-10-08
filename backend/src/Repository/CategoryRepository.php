<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function getTree()
    {
        // using raw sql for performance reasons
        $sql = "select * from category order by parent_id desc";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $items = $stmt->executeQuery()->fetchAllAssociative();

        $temp = [];
        foreach ($items as $r) {
            $temp[$r['id']] = $r;
        }

        $response = [];
        foreach ($items as $r) {
            if(!empty($r["parent_id"])) {
                $temp[$r['parent_id']]['children'][] = &$temp[$r['id']];
            }else{
                $response[] = &$temp[$r['id']];
            }
        }

        return $response;
    }
}
