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

        $this->addBasicJoins($qb);

        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getOneSite($id)
    {
        $qb = $this->createQueryBuilder('s');
        $this->addBasicJoins($qb);
        $qb->leftJoin('wd.workers', 'wo')->addSelect('wo');
        $qb->leftJoin('wo.completedTasks', 'ct')->addSelect('ct');
        $qb->leftJoin('ct.task', 'ta')->addSelect('ta');

        $qb->andWhere('s.id = :id');
        $qb->setParameter('id', $id);

        $query = $qb->getQuery();
        return $query->getResult();

    }

    /**
     * @return QueryBuilder
     */
    public function getSitesSimple()
    {
        $qb = $this->createQueryBuilder('s');
        $qb->where('s.active = 1');
        $qb->orderBy('s.shortName','ASC');

        return $qb;

    }

    /**
     * @param $searchString
     * @param $firstDayMin
     * @param $firstDayMax
     * @param $lastDayMin
     * @param $lastDayMax
     * @param $distance
     * @param $finished
     * @param $active
     * @param $flagged
     * @return mixed
     */
    public function searchSites($searchString, $firstDayMin,$firstDayMax,$lastDayMin,$lastDayMax,$distance,$finished,$active,$flagged)
    {
        $qb = $this->createQueryBuilder('s');
        $this->addBasicJoins($qb);
        $string = '%' . $searchString . '%';

        $qb->where('s.name LIKE :string');
        $qb->orWhere('s.shortName LIKE :string');
        $qb->orWhere('s.locality LIKE :string');
        $qb->setParameter('string', $string);

        if($firstDayMin || $firstDayMax){
            $qb->andWhere('s.firstWorkDay BETWEEN :min AND :max');
            if ($firstDayMin){
                $qb->setParameter('min', $firstDayMin);
            }else{
                $date = new \DateTime('2000-01-01');
                $qb->setParameter('min', $date);
            }
            if ($firstDayMax){
                $qb->setParameter('max', $firstDayMax);
            }else{
                $now = new \DateTime();
                $qb->setParameter('max', $now);
            }
        }

        if($lastDayMin || $lastDayMax){
            $qb->andWhere('s.lastWorkDay BETWEEN :min AND :max');
            if ($lastDayMin){
                $qb->setParameter('min', $lastDayMin);
            }else{
                $date = new \DateTime('2000-01-01');
                $qb->setParameter('min', $date);
            }
            if ($lastDayMax){
                $qb->setParameter('max', $lastDayMax);
            }else{
                $now = new \DateTime();
                $qb->setParameter('max', $now);
            }
        }
        //TODO distance;

        $qb->andWhere('s.finished = :finished');
        $qb->setParameter('finished', $finished);

        $qb->andWhere('s.active = :active');
        $qb->setParameter('active', $active);

        $qb->andWhere('wd.flagged = :flagged');
        $qb->setParameter('flagged', $flagged);



        $qb->groupBy('s.id');

        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * @param QueryBuilder $qb
     */
    public function addBasicJoins(QueryBuilder $qb): void
    {
        $qb->leftJoin('s.workDays', 'wd')->addSelect('wd');
        $qb->leftJoin('wd.author', 'au')->addSelect('au');
        $qb->leftJoin('wd.flags', 'fl')->addSelect('fl');
        $qb->leftJoin('s.participations', 'pa')->addSelect('pa');
        $qb->leftJoin('pa.person', 'pe')->addSelect('pe');

    }
}
