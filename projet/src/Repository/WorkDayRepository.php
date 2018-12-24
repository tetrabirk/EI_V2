<?php

namespace App\Repository;

use App\Entity\WorkDay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
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

        $this->addBasicJoins($qb);

        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function getOneWorkDay($id){
        $qb = $this->createQueryBuilder('wd');

        $this->addBasicJoins($qb);

        $qb->leftJoin('wd.site','s')->addSelect('s');
        $qb->leftJoin('s.participations','pa')->addSelect('pa');
        $qb->leftJoin('pa.person','pe')->addSelect('pe');

        $qb->andWhere('wd.id = :id');
        $qb->setParameter('id',$id);

        $query = $qb->getQuery();
        return $query->getResult();

    }

    public function searchWorkDays($searchString)
    {
        $qb = $this->createQueryBuilder('wd');
        $this->addBasicJoins($qb);
        $string = '%' . $searchString . '%';

        $qb->where('s.name LIKE :string');
        $qb->orWhere('s.shortName LIKE :string');
        $qb->orWhere('s.locality LIKE :string');
        $qb->setParameter('string', $string);

        $qb->groupBy('wd.id');
        $qb->orderBy('wd.date DESC'); //TODO pas moyen de changer le sens (???)
        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * @param QueryBuilder $qb
     */
    public function addBasicJoins(QueryBuilder $qb): void
    {
        $qb->leftJoin('wd.author','au')->addSelect('au');
        $qb->leftJoin('wd.workers','wo')->addSelect('wo');
        $qb->leftJoin('wo.completedTasks','ct')->addSelect('ct');
        $qb->leftJoin('ct.task','t')->addSelect('t');

    }
}
