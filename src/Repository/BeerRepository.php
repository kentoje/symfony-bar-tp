<?php

namespace App\Repository;

use App\Entity\Beer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Beer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Beer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Beer[]    findAll()
 * @method Beer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BeerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Beer::class);
    }

    /**
     * @param int $max
     * @return Beer[] Returns an array of Category objects.
     */
    public function findBeersDesc(int $max): array
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.id', 'DESC')
            ->setMaxResults($max)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param int $id
     * @return Beer[] Returns an array of Category objects.
    */
    public function findBeersByCategory(int $id): array
    {

        return $this
            ->createQueryBuilder('b')
            ->join('b.categories', 'c')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Beer Returns a Beer.
    */
    public function findFirstOne(): Beer
    {
        $result = $this
            ->createQueryBuilder('b')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;

        return $result[0];
    }

    /**
     * @param int $countryId
     * @return Beer[] Returns Beers.
    */
    public function findAllBeersFromCountry(int $countryId): array
    {
        return $this
            ->createQueryBuilder('b')
            ->join('b.country', 'c')
            ->where('c.id = :id')
            ->setParameter('id', $countryId)
            ->getQuery()
            ->getResult()
        ;
    }
}
