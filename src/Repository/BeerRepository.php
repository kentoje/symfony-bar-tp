<?php

namespace App\Repository;

use App\Entity\Beer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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
     * @return Beer[] Returns an array of Beers.
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
     * @return Beer[] Returns an array of Beers.
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
        [$beer] = $this
            ->createQueryBuilder('b')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;

        return $beer;
    }

    /**
     * @param int $countryId
     * @return Beer[] Returns an array of Beers.
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

    // TODO: Refacto in DQL
    public function findBeersByScoreGreaterThan(int $num): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sqlQueries = sprintf(
            'select * from beer as b inner join statistic as s on b.id = s.beer_id where s.score >= %d;',
            $num,
        );

        $stmt = $conn->prepare($sqlQueries);
        $stmt->execute();
        $results = $stmt->fetchAll();

        return $results;
    }
}
