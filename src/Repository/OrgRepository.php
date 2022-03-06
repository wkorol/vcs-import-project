<?php

namespace App\Repository;

use App\Entity\Org;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Org|null find($id, $lockMode = null, $lockVersion = null)
 * @method Org|null findOneBy(array $criteria, array $orderBy = null)
 * @method Org[]    findAll()
 * @method Org[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrgRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Org::class);
    }
}
