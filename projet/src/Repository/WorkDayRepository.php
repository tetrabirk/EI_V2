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

    public function searchWorkDays($dateMin,$dateMax,$site,$author,$workers,$validated,$flagged)
    {
        $qb = $this->createQueryBuilder('wd');
        $this->addBasicJoins($qb);

        if($dateMin || $dateMax){
            $qb->where('wd.date BETWEEN :min AND :max');
            if ($dateMin){
                $qb->setParameter('min', $dateMin);
            }else{
                $date = new \DateTime('2000-01-01');
                $qb->setParameter('min', $date);
            }
            if ($dateMax){
                $qb->setParameter('max', $dateMax);
            }else{
                $now = new \DateTime();
                $qb->setParameter('max', $now);
            }
        }
        if ($site)
        {
            $qb->expr()->in('wd.site',$site);
        }
        if ($author)
        {
            $qb->expr()->in('wd.author',$author);
        }
        if ($workers)
        {
            $qb->expr()->in('wd.workers',$workers);
        }
        if($validated)
        {
            $qb->andWhere('s.validated = :validated');
            $qb->setParameter('validated', $validated);

        }
        $qb->andWhere('wd.flagged = :flagged');
        $qb->setParameter('flagged', $flagged);

        $qb->groupBy('wd.id');
       // $qb->orderBy('wd.date DESC'); //TODO pas moyen de changer le sens (???)
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
