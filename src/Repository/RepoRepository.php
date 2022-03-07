<?php

namespace App\Repository;

use App\Entity\Org;
use App\Entity\Repo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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
    public function findOfType($provider)
    {
        $qb = $this->createQueryBuilder('r');
        $qb->where('r INSTANCE OF :provider');
        $qb->setParameter('provider', $provider);
        return $qb->getQuery()->getResult();
    }

    public function deleteOfType($provider, $orgName)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            DELETE FROM repo
            USING org
            WHERE repo.provider = :provider
            AND org.name = :orgName
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['provider' => $provider, 'orgName' => $orgName]);

        return $resultSet->fetchAllAssociative();

    }

    public function findOrgWithProvider($provider, $orgName)
    {
        return $this->createQueryBuilder('r')
            
            ->innerJoin(Org::class, 'o', \Doctrine\ORM\Query\Expr\Join::WITH, 'r.org = o.id')
            ->where('r INSTANCE OF :provider')
            ->andWhere('o.name = :orgName')
            ->setParameter('provider', $provider)
            ->setParameter('orgName', $orgName)
            ->setMaxResults(1)
            ->getQuery()->getResult()
        ;
    }
}
