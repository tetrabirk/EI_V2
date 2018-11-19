<?php

namespace App\Repository;

use App\Entity\Site;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Site|null find($id, $lockMode = null, $lockVersion = null)
 * @method Site|null findOneBy(array $criteria, array $orderBy = null)
 * @method Site[]    findAll()
 * @method Site[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Site::class);
    }
    public function testbyShortName($siteShortName)
    {

        $qb = $this->createQueryBuilder('s');
        $this->addAllJoins($qb);
        $qb->andWhere('s.shortName = :ssn');
        $qb->setParameter('ssn',$siteShortName);
        $this->returnResult($qb);

    }

    public function returnResult( QueryBuilder $qb)
    {
        $query = $qb->getQuery();
        return $query->getResult();

    }

    public function addAllJoins(QueryBuilder $qb)
    {
        $qb->leftJoin('s.workDays','wd')->addSelect('wd');
        $qb->leftJoin('wd.workers','w')->addSelect('w');
    }
//    /**
//     * @return Site[] Returns an array of Site objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Site
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
