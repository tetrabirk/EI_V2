<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Task::class);
    }
    public function getTaskList()
    {
        $qb = $this->createQueryBuilder('t');

        $qb->leftJoin('t.completedTasks','ct')->addSelect('ct');
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function getOneTask($id)
    {
        $qb = $this->createQueryBuilder('t');

        $qb->leftJoin('t.completedTasks','ct')->addSelect('ct');
        $qb->leftJoin('ct.worker','wo')->addSelect('wo');

        $qb->andWhere('t.id = :id');
        $qb->setParameter('id',$id);

        $query = $qb->getQuery();
        return $query->getResult();

    }
}
