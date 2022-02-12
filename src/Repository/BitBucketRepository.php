<?php

namespace App\Repository;

use App\Entity\BitBucket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BitBucket|null find($id, $lockMode = null, $lockVersion = null)
 * @method BitBucket|null findOneBy(array $criteria, array $orderBy = null)
 * @method BitBucket[]    findAll()
 * @method BitBucket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BitBucketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BitBucket::class);
    }

    // /**
    //  * @return BitBucket[] Returns an array of BitBucket objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BitBucket
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
