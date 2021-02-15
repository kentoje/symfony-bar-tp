<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
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

    public function findCatSpecial(int $id)
    {
        return $this
            ->createQueryBuilder('c')
            ->join('c.beer', 'b')
            ->where('b.id = :id')
            ->setParameter('id', $id)
            ->andWhere('c.term = :term')
            ->setParameter('term', 'special')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findNormalCats()
    {
        return $this
            ->createQueryBuilder('c')
            ->orderBy('c.name')
            ->where('c.term = :term')
            ->setParameter('term', 'normal')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Category[] Returns an array of Category objects.
    */
    public function findAllNormal(): array
    {
        return $this
            ->createQueryBuilder('c')
            ->where('c.term = :val')
            ->setParameter('val', 'normal')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Category[] Returns an array of Category objects.
     */
    public function findAllSpecial(): array
    {
        return $this
            ->createQueryBuilder('c')
            ->where('c.term = :val')
            ->setParameter('val', 'special')
            ->getQuery()
            ->getResult()
        ;
    }
}
