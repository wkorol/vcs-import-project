<?php

namespace App\Repository;

use App\Entity\Repos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Repos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Repos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Repos[]    findAll()
 * @method Repos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReposRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Repos::class);
    }

    // /**
    //  * @return Repos[] Returns an array of Repos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Repos
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
