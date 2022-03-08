<?php

namespace App\Repository;

use App\Entity\Org;
use App\Entity\Repo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
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

    /**
     * @throws Exception
     */
    public function deleteOfType($provider, $orgName)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            DELETE FROM repo AS r USING org AS o WHERE r.org_id = o.id AND o.name = :orgName AND r.provider = :provider
            ';
        $stmt = $conn->prepare($sql);

        $stmt->executeQuery(['provider' => $provider,'orgName' => $orgName]);


    }

    public function findOrgWithProvider($provider, $orgName)
    {
        return $this->createQueryBuilder('r')
            
            ->innerJoin(Org::class, 'o', Join::WITH, 'r.org = o.id')
            ->where('r INSTANCE OF :provider')
            ->andWhere('o.name = :orgName')
            ->setParameter('provider', $provider)
            ->setParameter('orgName', $orgName)
            ->setMaxResults(1)
            ->getQuery()->getResult()
        ;
    }
}
