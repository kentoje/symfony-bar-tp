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

    /**
     * @param int $id
     * @return Category[] Returns an array of Category objects.
    */
    public function findSpecialCatByBeerId(int $id): array
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

    /**
     * @param int $id
     * @return Category[] Returns an array of Category objects.
    */
    public function findNormalCatByBeerId(int $id): array
    {
        return $this
            ->createQueryBuilder('c')
            ->join('c.beer', 'b')
            ->where('b.id = :id')
            ->setParameter('id', $id)
            ->andWhere('c.term = :term')
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

    /**
     * @return Category Returns a Category.
    */
    public function findFirstOne(): Category
    {
        [$category] = $this
            ->createQueryBuilder('c')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;

        return $category;
    }

    /**
     * @param int $beerId
     * @return Category Returns a Category.
    */
    public function findNormalCategoryByBeerId(int $beerId): Category
    {
        [$category] = $this
            ->createQueryBuilder('c')
            ->join('c.beer', 'b')
            ->where('b.id = :beerId')
            ->setParameter('beerId', $beerId)
            ->andWhere('c.term = :term')
            ->setParameter('term', 'normal')
            ->getQuery()
            ->getResult()
        ;

        return $category;
    }
}
