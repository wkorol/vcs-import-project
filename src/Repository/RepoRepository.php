<?php

namespace App\Repository;

use App\Entity\Org;
use App\Entity\Repo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Repo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Repo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Repo[]    findAll()
 * @method Repo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Repo::class);
    }

    // /**
    //  * @return Repo[] Returns an array of Repo objects
    //  */

    public function showAllRepos()
    {
        return $this->createQueryBuilder('r')

            ->leftJoin(Org::class, 'o', \Doctrine\ORM\Query\Expr\Join::WITH, 'r.org = o.id')
            ->orderBy('r.create_date', 'DESC' )
            ->getQuery()->getResult()

        ;
    }

    public function sortByPoints() {
        return $this->createQueryBuilder('r')
            ->leftJoin(Org::class, 'o', \Doctrine\ORM\Query\Expr\Join::WITH, 'r.org = o.id')
            ->orderBy('r.points', 'ASC')
            ->getQuery()->getResult()
            ;
    }



}
