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

    public function getSiteList()
    {
        $qb = $this->createQueryBuilder('s');

        $qb->leftJoin('s.workDays','wd')->addSelect('wd');
        $qb->leftJoin('wd.flags','fl')->addSelect('fl');
        $qb->leftJoin('s.participations','pa')->addSelect('pa');
        $qb->leftJoin('pa.person','pe')->addSelect('pe');

        $query = $qb->getQuery();
        return $query->getResult();
    }


    public function getOneSite($id)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->leftJoin('s.workDays','wd')->addSelect('wd');
        $qb->leftJoin('wd.author','au')->addSelect('au');
        $qb->leftJoin('wd.workers','wo')->addSelect('wo');
        $qb->leftJoin('wd.flags','fl')->addSelect('fl');
        $qb->leftJoin('wo.completedTasks','ct')->addSelect('ct');
        $qb->leftJoin('ct.task','ta')->addSelect('ta');
        $qb->leftJoin('s.participations','pa')->addSelect('pa');
        $qb->leftJoin('pa.person','pe')->addSelect('pe');

        $qb->andWhere('s.id = :id');
        $qb->setParameter('id',$id);


        $query = $qb->getQuery();
        return $query->getResult();

    }

}
