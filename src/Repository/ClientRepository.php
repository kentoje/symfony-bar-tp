<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    /**
     * @return Client Returns a Client.
    */
    public function findFirstOne(): Client
    {
        [$client] = $this
            ->createQueryBuilder('c')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;

        return $client;
    }

    /**
     * @return float Returns float average.
    */
    public function calcAverageBeerPerClient(): float
    {
        [$data] = $this
            ->createQueryBuilder('b')
            ->select('AVG(b.number_beer) AS average')
            ->getQuery()
            ->getResult()
        ;

        return $data['average'];
    }

    /**
     * @return Client[] Returns clients order by number of beer desc.
    */
    public function findAllOrderByBeerDesc(): array
    {
        return $this
            ->createQueryBuilder('c')
            ->orderBy('c.number_beer', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * STD() SQL Function returns the standard deviation ("écart type")
     * @return float Returns float average.
    */
    public function findStandardDeviationFromNumBeer(): float
    {
        [$data] = $this
            ->createQueryBuilder('c')
            ->select('STD(c.number_beer) AS deviation')
            ->getQuery()
            ->getResult()
        ;

        return $data['deviation'];
    }
}
