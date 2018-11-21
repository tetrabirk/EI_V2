<?php

namespace App\Repository;

use App\Entity\WorkDay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WorkDay|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkDay|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkDay[]    findAll()
 * @method WorkDay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkDayRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WorkDay::class);
    }
    public function getWorkdayList(){
        $qb = $this->createQueryBuilder('wd');

        $qb->leftJoin('wd.author','au')->addSelect('au');
        $qb->leftJoin('wd.workers','wo')->addSelect('wo');
        $qb->leftJoin('wo.completedTasks','ct')->addSelect('ct');
        $qb->leftJoin('ct.task','t')->addSelect('t');


        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function getOneWorkDay($id){
        $qb = $this->createQueryBuilder('wd');
        $qb->leftJoin('wd.site','s')->addSelect('s');
        $qb->leftJoin('wd.author','au')->addSelect('au');
        $qb->leftJoin('wd.workers','wo')->addSelect('wo');
        $qb->leftJoin('wo.completedTasks','ct')->addSelect('ct');
        $qb->leftJoin('ct.task','ta')->addSelect('ta');
        $qb->leftJoin('s.participations','pa')->addSelect('pa');
        $qb->leftJoin('pa.person','pe')->addSelect('pe');

        $qb->andWhere('wd.id = :id');
        $qb->setParameter('id',$id);

        $query = $qb->getQuery();
        return $query->getResult();

    }

}
