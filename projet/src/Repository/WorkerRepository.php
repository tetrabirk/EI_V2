<?php

namespace App\Repository;

use App\Entity\Worker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Worker|null find($id, $lockMode = null, $lockVersion = null)
 * @method Worker|null findOneBy(array $criteria, array $orderBy = null)
 * @method Worker[]    findAll()
 * @method Worker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Worker::class);
    }

    public function getOneWorker()
{
    $qb = $this->createQueryBuilder('w');

    $qb->leftJoin('w.participations','pa')->addSelect('pa');
    $qb->leftJoin('w.site','si')->addSelect('si');
    $qb->leftJoin('w.completedTask','ct')->addSelect('ct');
    $qb->leftJoin('ct.task','ta')->addSelect('ta');

}
}
